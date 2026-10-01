<?php

namespace App\Http\Controllers\Verse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\VerseImport;
use App\Models\Book;
use App\Models\Version;
use App\Models\VerseImportJob;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Rules\ExistsInMysql2;

class VerseImportController extends Controller
{
    public function verse_import()
    {
        if (!has_permission('verse_menu', 'import')) {
            abort(403);
        }
        if (!has_module_access('verse_menu')) {
            abort(403);
        }

        $bookList = Book::where('title', '!=', '')
                ->select(\DB::raw('MAX(version_id) as version_id'), 'version_id', \DB::raw('COUNT(*) as sub_category_count'))
                ->groupBy('version_id')
                ->orderBy('sub_category_count', 'desc')
                ->pluck('version_id');

        $versions = Version::orderBy('id','desc')->where('deleted_at',0)->get();

        return view('admin.version.verse.import', compact('versions'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:51200', // Max 50MB
            'version_id' => ['required', new ExistsInMysql2('versions', 'id')],
        ]);

        try {
            $file = $request->file('file');
            $version_id = $request->input('version_id');
            $user_id = auth()->guard('admin')->id();
            
            // Create import job record
            $importJob = VerseImportJob::create([
                'version_id' => $version_id,
                'user_id' => $user_id,
                'file_path' => $file->store('temp'),
                'original_filename' => $file->getClientOriginalName(),
                'status' => 'pending',
                'progress' => 0,
                'status_message' => 'Waiting to be processed',
            ]);
            
            // Check file size to determine processing method
            $fileSizeInBytes = $file->getSize();
            $fileSizeInMB = $fileSizeInBytes / 1024 / 1024;
            
            // If file is larger than 5MB or estimated to have more than 10,000 rows, use queue
            if ($fileSizeInMB > 5 || $this->estimateRowCount($file) > 10000) {
                return response()->json([
                    'success' => true,
                    'message' => 'Large file detected. Import has been queued for background processing.',
                    'queued' => true,
                    'import_job_id' => $importJob->id,
                    'version_id' => $version_id,
                ]);
            } else {
                // Process immediately
                $import = new VerseImport($version_id);
                Excel::import($import, $file);
                
                $results = $import->getResults();
                
                // Update job with results
                $importJob->update([
                    'status' => 'completed',
                    'progress' => 100,
                    'total_rows' => $results['total'] ?? 0,
                    'processed_rows' => $results['total'] ?? 0,
                    'added_count' => $results['added'] ?? 0,
                    'updated_count' => $results['updated'] ?? 0,
                    'failed_count' => $results['failed'] ?? 0,
                    'completed_at' => now(),
                    'status_message' => 'Import completed successfully',
                ]);
                
                // Cleanup file
                Storage::delete($importJob->file_path);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Import completed successfully',
                    'results' => $results,
                    'import_job_id' => $importJob->id,
                ]);
            }
            
        } catch (\Exception $e) {
            // Update job with error if it exists
            if (isset($importJob)) {
                $importJob->update([
                    'status' => 'failed',
                    'error_message' => $e->getMessage(),
                    'completed_at' => now(),
                ]);
            }
            
            Log::error('Import failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Import failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function checkImportStatus(Request $request)
    {
        $request->validate([
            'import_job_id' => 'required|integer|exists:verse_import_jobs,id'
        ]);

        $importJob = VerseImportJob::findOrFail($request->input('import_job_id'));
        $user_id = auth()->guard('admin')->id();

        // Verify user owns this job
        if ($importJob->user_id != $user_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'You do not have permission to view this import job'
            ], 403);
        }

        try {
            switch($importJob->status) {
                case 'completed':
                    return response()->json([
                        'status' => 'completed',
                        'results' => [
                            'total' => $importJob->total_rows,
                            'added' => $importJob->added_count,
                            'updated' => $importJob->updated_count,
                            'failed' => $importJob->failed_count,
                        ],
                        'progress' => 100,
                        'processed_rows' => $importJob->processed_rows,
                        'total_rows' => $importJob->total_rows,
                        'completed_at' => $importJob->completed_at,
                        'summary' => [
                            'total' => $importJob->total_rows,
                            'added' => $importJob->added_count,
                            'updated' => $importJob->updated_count,
                            'failed' => $importJob->failed_count,
                            'success_rate' => $this->calculateSuccessRate($importJob)
                        ]
                    ]);
                
                case 'failed':
                    return response()->json([
                        'status' => 'failed',
                        'error' => $importJob->error_message,
                        'progress' => $importJob->progress,
                        'processed_rows' => $importJob->processed_rows,
                        'total_rows' => $importJob->total_rows,
                        'failed_at' => $importJob->completed_at,
                    ]);
                
                case 'processing':
                    return response()->json([
                        'status' => 'processing',
                        'progress' => $importJob->progress,
                        'status_message' => $importJob->status_message,
                        'processed_rows' => $importJob->processed_rows,
                        'total_rows' => $importJob->total_rows,
                        'updated_at' => $importJob->updated_at->diffForHumans(),
                        'estimated_time_remaining' => $this->calculateEstimatedTimeRemaining($importJob)
                    ]);
                
                case 'pending':
                    return response()->json([
                        'status' => 'pending',
                        'message' => 'Import is waiting to be processed',
                        'created_at' => $importJob->created_at->diffForHumans(),
                    ]);
                
                default:
                    return response()->json([
                        'status' => 'unknown',
                        'message' => 'Import status could not be determined',
                    ]);
            }
            
        } catch (\Exception $e) {
            Log::error('Error checking import status', [
                'import_job_id' => $importJob->id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to check import status',
                'error' => $e->getMessage()
            ], 200);
        }
    }

    public function downloadImportReport(Request $request)
    {
        $request->validate([
            'import_job_id' => 'required|integer|exists:verse_import_jobs,id'
        ]);

        $importJob = VerseImportJob::findOrFail($request->input('import_job_id'));
        $user_id = auth()->guard('admin')->id();

        // Verify user owns this job
        if ($importJob->user_id != $user_id) {
            abort(403, 'You do not have permission to view this import job');
        }

        try {
            if ($importJob->status !== 'completed') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No import results available for this job'
                ], 200);
            }
            
            // Generate CSV report
            $csvData = $this->generateImportReportCsv($importJob);
            $filename = "import_report_{$importJob->id}_" . date('Y-m-d_H-i-s') . '.csv';
            
            return response($csvData)
                ->header('Content-Type', 'text/csv')
                ->header('Content-Disposition', "attachment; filename=\"{$filename}\"");
                
        } catch (\Exception $e) {
            Log::error('Error downloading import report', [
                'import_job_id' => $importJob->id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to generate import report',
                'error' => $e->getMessage()
            ], 200);
        }
    }
    
    private function calculateSuccessRate(VerseImportJob $importJob)
    {
        if ($importJob->total_rows === 0) {
            return 0;
        }
        
        $successful = $importJob->total_rows - $importJob->failed_count;
        return round(($successful / $importJob->total_rows) * 100, 2);
    }
    
    private function calculateEstimatedTimeRemaining(VerseImportJob $importJob)
    {
        if (!$importJob->started_at || $importJob->progress <= 0) {
            return 'Calculating...';
        }
        
        try {
            $elapsedTime = $importJob->started_at->diffInSeconds(now());
            $progressPercent = $importJob->progress / 100;
            
            if ($progressPercent <= 0) {
                return 'Calculating...';
            }
            
            $totalEstimatedTime = $elapsedTime / $progressPercent;
            $remainingTime = $totalEstimatedTime - $elapsedTime;
            
            if ($remainingTime <= 0) {
                return 'Almost done...';
            }
            
            return $this->formatDuration($remainingTime);
            
        } catch (\Exception $e) {
            return 'Unknown';
        }
    }
    
    private function formatDuration($seconds)
    {
        if ($seconds < 60) {
            return round($seconds) . ' seconds';
        } elseif ($seconds < 3600) {
            return round($seconds / 60) . ' minutes';
        } else {
            return round($seconds / 3600, 1) . ' hours';
        }
    }
    
    private function generateImportReportCsv(VerseImportJob $importJob)
    {
        $csvData = "Import Report for Job ID {$importJob->id}\n";
        $csvData .= "Original File: {$importJob->original_filename}\n";
        $csvData .= "Version ID: {$importJob->version_id}\n";
        $csvData .= "Started At: {$importJob->started_at}\n";
        $csvData .= "Completed At: {$importJob->completed_at}\n";
        $csvData .= "Generated at: " . now()->format('Y-m-d H:i:s') . "\n\n";
        
        $csvData .= "Summary\n";
        $csvData .= "Total Rows,{$importJob->total_rows}\n";
        $csvData .= "Added,{$importJob->added_count}\n";
        $csvData .= "Updated,{$importJob->updated_count}\n";
        $csvData .= "Failed,{$importJob->failed_count}\n";
        $csvData .= "Success Rate,{$this->calculateSuccessRate($importJob)}%\n";
        
        return $csvData;
    }

    protected function estimateRowCount($file)
    {
        $fileSizeInBytes = $file->getSize();
        $extension = strtolower($file->getClientOriginalExtension());
        
        // Rough estimates based on file type and size
        switch ($extension) {
            case 'csv':
                return intval($fileSizeInBytes / 150); // ~150 bytes per row average
            case 'xlsx':
                return intval($fileSizeInBytes / 100); // ~100 bytes per row average (compressed)
            case 'xls':
                return intval($fileSizeInBytes / 80);  // ~80 bytes per row average
            default:
                return intval($fileSizeInBytes / 120); // Default estimate
        }
    }
    
    public function getImportProgress(Request $request)
    {
        // This would require implementing progress tracking in the import class
        // For now, return basic status
        return $this->checkImportStatus($request);
    }
}