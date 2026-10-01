<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\VerseImport;
use App\Models\VerseImportJob;
use Illuminate\Support\Facades\Schema;

class VerseImportCronJob extends Command
{
    protected $signature = 'verse:import-process {--check-pending : Check for pending imports only}';
    protected $description = 'Process pending verse import files';

    public function handle()
    {
        if ($this->option('check-pending')) {
            $this->checkPendingImports();
            return;
        }

        $this->info('Starting verse import cron job...');
        
        // Get pending imports from database
        $pendingImports = VerseImportJob::where('status', 'pending')
            ->orderBy('created_at', 'asc')
            ->get();
        
        if ($pendingImports->isEmpty()) {
            $this->info('No pending imports found.');
            return;
        }

        $this->info('Found ' . $pendingImports->count() . ' pending import(s).');

        foreach ($pendingImports as $importJob) {
            try {
                $this->processImport($importJob);
            } catch (\Exception $e) {
                $this->error('Failed to process import: ' . $e->getMessage());
                $this->updateImportStatus($importJob, 'failed', 0, $e->getMessage());
                Log::error('Cron import failed', [
                    'import_job_id' => $importJob->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        $this->info('Verse import cron job completed.');
    }

    protected function processImport(VerseImportJob $importJob)
    {
        $filePath = $importJob->file_path;
        $versionId = $importJob->version_id;
        $userId = $importJob->user_id;

        $this->info("Processing import job ID {$importJob->id} for version {$versionId}...");

        // Update status to processing
        $this->updateImportStatus($importJob, 'processing', 0, 'Starting import process');

        // Validate file exists
        if (!Storage::exists($filePath)) {
            throw new \Exception("Import file not found: {$filePath}");
        }

        $this->updateImportStatus($importJob, 'processing', 5, 'File validation complete');

        // Get total rows count
        $totalRows = $this->getTotalRowsCount($filePath);
        $importJob->total_rows = $totalRows;
        $importJob->save();

        $versionTableName = 'record' . $versionId;

        $connection = \DB::connection('mysql2');
        if (!Schema::connection('mysql2')->hasColumn($versionTableName, 'word_ids')) {
            $connection->statement("ALTER TABLE `$versionTableName` ADD `word_ids` LONGTEXT NOT NULL");
        }
        
        $this->updateImportStatus($importJob, 'processing', 10, "Found {$totalRows} rows to process");

        // Create import instance
        $import = new VerseImport($versionId);
        
        // Set up progress tracking
        $processedRows = 0;
        if (method_exists($import, 'setProgressCallback')) {
            $import->setProgressCallback(function($rows) use (&$processedRows, $totalRows, $importJob) {
                $processedRows = $rows;
                if ($totalRows > 0 && ($rows % 100 === 0 || $rows === $totalRows)) {
                    $progress = 15 + (($rows / $totalRows) * 75); // 15% to 90%
                    $this->updateImportStatus(
                        $importJob, 
                        'processing', 
                        round($progress), 
                        "Processing row {$rows} of {$totalRows}",
                        $rows
                    );
                }
            });
        }

        $this->updateImportStatus($importJob, 'processing', 15, 'Starting Excel import process');

        // Process the import
        Excel::import($import, $filePath, null, \Maatwebsite\Excel\Excel::XLSX);

        $this->updateImportStatus($importJob, 'processing', 90, 'Excel import processing complete', $totalRows);

        // Get results
        $results = $import->getResults();
        $this->updateImportStatus($importJob, 'processing', 95, 'Finalizing import', $totalRows);

        // Update job with results
        $importJob->added_count = $results['added'] ?? 0;
        $importJob->updated_count = $results['updated'] ?? 0;
        $importJob->failed_count = $results['failed'] ?? 0;
        $importJob->processed_rows = $totalRows;
        $importJob->save();

        $this->info("Import completed successfully for version {$versionId}");
        Log::info("Verse import completed successfully", [
            'import_job_id' => $importJob->id,
            'version_id' => $versionId,
            'total' => $results['total'] ?? 0,
            'added' => $results['added'] ?? 0,
            'updated' => $results['updated'] ?? 0,
            'failed' => $results['failed'] ?? 0
        ]);

        $this->updateImportStatus($importJob, 'processing', 98, 'Cleaning up temporary files', $totalRows);
        $this->cleanupFile($filePath);

        $this->updateImportStatus($importJob, 'completed', 100, 'Import completed successfully', $totalRows);
        
        // Send notification if possible
        $this->notifyUser($importJob);
    }

    protected function updateImportStatus(VerseImportJob $importJob, $status, $progress, $message, $processedRows = null)
    {
        $importJob->status = $status;
        $importJob->progress = max(0, min(100, $progress));
        $importJob->status_message = $message;
        
        if ($processedRows !== null) {
            $importJob->processed_rows = $processedRows;
        }
        
        if ($status === 'processing' && !$importJob->started_at) {
            $importJob->started_at = now();
        }
        
        if ($status === 'completed' || $status === 'failed') {
            $importJob->completed_at = now();
        }
        
        $importJob->save();

        $this->info("Progress: {$progress}% - {$message}");
    }

    protected function getTotalRowsCount($filePath)
    {
        try {
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load(Storage::path($filePath));
            $worksheet = $spreadsheet->getActiveSheet();
            $highestRow = $worksheet->getHighestRow();
            
            return max(0, $highestRow - 1); // Subtract 1 for header row
        } catch (\Exception $e) {
            Log::warning("Could not determine total rows count", ['error' => $e->getMessage()]);
            return 0;
        }
    }

    protected function cleanupFile($filePath)
    {
        try {
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
                $this->info("Cleaned up import file: {$filePath}");
            }
        } catch (\Exception $e) {
            $this->error("Failed to cleanup import file: " . $e->getMessage());
            Log::warning("Failed to cleanup import file", [
                'file_path' => $filePath,
                'error' => $e->getMessage()
            ]);
        }
    }

    protected function notifyUser(VerseImportJob $importJob)
    {
        if (!$importJob->user_id) {
            return;
        }

        try {
            $user = \App\Models\Admin::find($importJob->user_id);
            if ($user && class_exists('\App\Notifications\ImportCompleted')) {
                $user->notify(new \App\Notifications\ImportCompleted([
                    'import_job_id' => $importJob->id,
                    'version_id' => $importJob->version_id,
                    'total' => $importJob->total_rows,
                    'added' => $importJob->added_count,
                    'updated' => $importJob->updated_count,
                    'failed' => $importJob->failed_count,
                ]));
                $this->info("Import notification sent to user: {$importJob->user_id}");
            }
        } catch (\Exception $e) {
            $this->error("Failed to send import notification: " . $e->getMessage());
            Log::error("Failed to send import notification", [
                'user_id' => $importJob->user_id,
                'error' => $e->getMessage()
            ]);
        }
    }

    protected function checkPendingImports()
    {
        $pendingImports = VerseImportJob::where('status', 'pending')
            ->orderBy('created_at', 'asc')
            ->get();
        
        if ($pendingImports->isEmpty()) {
            $this->info('No pending imports found.');
            return;
        }

        $this->info('Pending imports:');
        foreach ($pendingImports as $import) {
            $this->line("- ID: {$import->id}, Version ID: {$import->version_id}, User ID: {$import->user_id}, Created: {$import->created_at}");
        }
    }
}