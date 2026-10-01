<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\VerseImport;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class VerseImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;
    protected $version_id;
    protected $userId;
    
    // Job timeout in seconds (30 minutes)
    public $timeout = 1800;
    
    // Number of times the job may be attempted
    public $tries = 3;

    // Track progress properties
    public $progress = 0;
    public $processedRows = 0;
    public $totalRows = 0;

    // Progress update frequency (update every X rows)
    protected $progressUpdateFrequency = 100;

    public function __construct($filePath, $version_id, $userId = null)
    {
        $this->filePath = $filePath;
        $this->version_id = $version_id;
        $this->userId = $userId;
    }

    public function handle()
    {
        try {
            Log::info("Starting verse import job for version: {$this->version_id}");
            $this->updateProgress(0, 'Starting import job');
            
            if (!Storage::exists($this->filePath)) {
                throw new \Exception("Import file not found: {$this->filePath}");
            }
            
            $this->updateProgress(5, 'File validation complete');

            // Get total rows count
            $this->totalRows = $this->getTotalRowsCount();
            $this->updateProgress(10, "Found {$this->totalRows} rows to process");
            
            $import = new VerseImport($this->version_id);
            
            // Set up progress callback with batch processing
            if (method_exists($import, 'setProgressCallback')) {
                $import->setProgressCallback(function($processedRows) {
                    $this->processedRows = $processedRows;
                    
                    // Only update progress every 100 rows or 5% to reduce overhead
                    if ($this->totalRows > 0 && 
                        ($processedRows % 100 === 0 || 
                        $processedRows === $this->totalRows)) {
                        $this->updateProgressPercentage();
                    }
                });
            }
            $this->updateProgress(15, 'Starting Excel import process');
            
            // Import with batch size configuration
            Excel::import($import, $this->filePath, null, \Maatwebsite\Excel\Excel::XLSX);
            
            // Ensure final progress update
            $this->processedRows = $this->totalRows;
            $this->updateProgress(90, 'Excel import processing complete');
            
            // Get results
            $results = $import->getResults();
            $this->totalRows = $results['total'] ?? $this->totalRows;
            $this->processedRows = $this->totalRows;
            
            $this->updateProgress(95, 'Caching import results');
            $this->cacheResults($results);
            
            Log::info("Verse import completed successfully", [
                'version_id' => $this->version_id,
                'total' => $results['total'] ?? 0,
                'added' => $results['added'] ?? 0,
                'updated' => $results['updated'] ?? 0,
                'failed' => $results['failed'] ?? 0
            ]);
            
            $this->updateProgress(98, 'Cleaning up temporary files');
            $this->cleanupFile();
            
            $this->updateProgress(100, 'Import completed successfully');
            $this->notifyUser($results);
            
        } catch (\Exception $e) {
            $this->handleJobFailure($e);
            throw $e;
        }
    }
    
    protected function getTotalRowsCount()
    {
        try {
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load(Storage::path($this->filePath));
            $worksheet = $spreadsheet->getActiveSheet();
            $highestRow = $worksheet->getHighestRow();
            
            // Subtract 1 for header row if exists
            return max(0, $highestRow - 1);
        } catch (\Exception $e) {
            Log::warning("Could not determine total rows count", ['error' => $e->getMessage()]);
            return 0;
        }
    }
    
    protected function updateProgressPercentage()
    {
        if ($this->totalRows > 0) {
            // Calculate progress between 15% and 90% based on row processing
            $baseProgress = 15;
            $maxProgress = 90;
            $progressRange = $maxProgress - $baseProgress;
            
            $rowProgress = min(
                $progressRange,
                ($this->processedRows / $this->totalRows) * $progressRange
            );
            
            $percentage = $baseProgress + $rowProgress;
            
            $this->updateProgress(
                round($percentage), 
                "Processing row {$this->processedRows} of {$this->totalRows}"
            );
        }
    }
    
    protected function updateProgress($progress, $status = null)
    {
        $this->progress = max(0, min(100, $progress));
        
        Log::info("Import progress updated", [
            'version_id' => $this->version_id,
            'progress' => $this->progress,
            'status' => $status,
            'processed_rows' => $this->processedRows,
            'total_rows' => $this->totalRows
        ]);
        
        $progressData = [
            'progress' => $this->progress,
            'status' => $status ?: 'Processing...',
            'processed_rows' => $this->processedRows,
            'total_rows' => $this->totalRows,
            'updated_at' => now(),
            'version_id' => $this->version_id,
            'user_id' => $this->userId
        ];
        
        // Store progress in cache
        Cache::put($this->getProgressCacheKey(), $progressData, 3600);
        
        // Also store in job-specific cache if job ID exists
        if (isset($this->job) && $this->job) {
            Cache::put("job_progress_{$this->job->getJobId()}", $progressData, 3600);
        }
    }
    
    protected function cacheResults($results)
    {
        $cacheData = array_merge($results, [
            'completed_at' => now(),
            'version_id' => $this->version_id,
            'user_id' => $this->userId,
            'file_path' => $this->filePath
        ]);
        
        Cache::put($this->getResultsCacheKey(), $cacheData, 3600);
    }
    
    protected function handleJobFailure(\Exception $e)
    {
        Log::error("Verse import job failed", [
            'version_id' => $this->version_id,
            'user_id' => $this->userId,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'progress' => $this->progress,
            'processed_rows' => $this->processedRows,
            'total_rows' => $this->totalRows
        ]);
        
        Cache::put($this->getErrorCacheKey(), [
            'error' => $e->getMessage(),
            'failed_at' => now(),
            'progress' => $this->progress,
            'processed_rows' => $this->processedRows,
            'total_rows' => $this->totalRows,
            'version_id' => $this->version_id,
            'user_id' => $this->userId,
            'attempt' => $this->attempts()
        ], 3600);
    }
    
    protected function cleanupFile()
    {
        try {
            if (Storage::exists($this->filePath)) {
                Storage::delete($this->filePath);
                Log::info("Cleaned up import file: {$this->filePath}");
            }
        } catch (\Exception $e) {
            Log::warning("Failed to cleanup import file", [
                'file_path' => $this->filePath,
                'error' => $e->getMessage()
            ]);
        }
    }
    
    protected function notifyUser($results)
    {
        if (!$this->userId) {
            return;
        }
        
        // Example notification implementation
        try {
            $user = \App\Models\Admin::find($this->userId);
            if ($user) {
                $user->notify(new \App\Notifications\ImportCompleted([
                    'version_id' => $this->version_id,
                    'total' => $results['total'] ?? 0,
                    'added' => $results['added'] ?? 0,
                    'updated' => $results['updated'] ?? 0,
                    'failed' => $results['failed'] ?? 0,
                    'file_path' => $this->filePath
                ]));
                Log::info("Import notification sent to user: {$this->userId}");
            }
        } catch (\Exception $e) {
            Log::error("Failed to send import notification", [
                'user_id' => $this->userId,
                'error' => $e->getMessage()
            ]);
        }
    }
    
    public function failed(\Exception $exception)
    {
        Log::error("Verse import job permanently failed", [
            'version_id' => $this->version_id,
            'user_id' => $this->userId,
            'error' => $exception->getMessage(),
            'attempts' => $this->attempts()
        ]);
        
        Cache::put($this->getFailedCacheKey(), [
            'error' => $exception->getMessage(),
            'failed_at' => now(),
            'attempts' => $this->attempts(),
            'progress' => $this->progress,
            'processed_rows' => $this->processedRows,
            'total_rows' => $this->totalRows,
            'version_id' => $this->version_id,
            'user_id' => $this->userId
        ], 7200);
        
        $this->cleanupFile();
    }
    
    protected function getProgressCacheKey()
    {
        return "import_progress_{$this->version_id}_{$this->userId}";
    }
    
    protected function getResultsCacheKey()
    {
        return "import_results_{$this->version_id}_{$this->userId}";
    }
    
    protected function getErrorCacheKey()
    {
        return "import_error_{$this->version_id}_{$this->userId}";
    }
    
    protected function getFailedCacheKey()
    {
        return "import_failed_{$this->version_id}_{$this->userId}";
    }
    
    public static function getProgress($version_id, $userId = null)
    {
        return Cache::get("import_progress_{$version_id}_{$userId}");
    }
    
    public static function getResults($version_id, $userId = null)
    {
        return Cache::get("import_results_{$version_id}_{$userId}");
    }
    
    public static function getError($version_id, $userId = null)
    {
        return Cache::get("import_error_{$version_id}_{$userId}");
    }
    
    public static function clearCache($version_id, $userId = null)
    {
        $keys = [
            "import_progress_{$version_id}_{$userId}",
            "import_results_{$version_id}_{$userId}",
            "import_error_{$version_id}_{$userId}",
            "import_failed_{$version_id}_{$userId}"
        ];
        
        foreach ($keys as $key) {
            Cache::forget($key);
        }
    }
}