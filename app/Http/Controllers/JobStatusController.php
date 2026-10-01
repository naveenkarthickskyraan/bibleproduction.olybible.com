<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;
use App\Models\Version;

class JobStatusController extends Controller
{
    /**
     * Path to store job status
     */
    private $statusFilePath;

    public function __construct()
    {
        $this->statusFilePath = storage_path('app/bible_job_status.json');
    }

    /**
     * Display the job status monitoring page.
     *
     * @return \Illuminate\View\View
     */
    public function showStatus()
    {
        $status = $this->getJobStatus();
        $versions = Version::where('deleted_at',0)->get();
        return view('admin.job.job-status', compact('status','versions'));
    }

    /**
     * Get the job status as JSON for AJAX polling.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStatusApi()
    {
        $status = $this->getJobStatus();
        return response()->json($status);
    }

    /**
     * Start the Bible word check job.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function startJob()
    {
        if (!has_permission('cron_job_menu', 'create')) {
            return response()->json([
                'error' => true,
                'message' => 'Permission denied. You are not authorized to perform this action.'
            ], 400);
        }
        if(!has_module_access('cron_job_menu')) {
            return response()->json([
                'error' => true,
                'message' => 'Permission denied. You are not authorized to perform this action.'
            ], 400);
        }

        try {
            // Check if job is already running
            $currentStatus = $this->getJobStatus();
            if (isset($currentStatus['status']) && $currentStatus['status'] === 'In Progress') {
                return response()->json([
                    'success' => false,
                    'message' => 'Job is already running.'
                ], 400);
            }

            // Initialize job status
            $this->updateJobStatus([
                'status' => 'Starting...',
                'progress' => 0,
                'current_version' => '',
                'current_verse_count' => 0,
                'total_verses_in_version' => 0,
                'processed_versions' => 0,
                'total_versions' => 0,
                'last_updated' => \Carbon\Carbon::now()->addHours(5)->addMinutes(30)->format('Y-m-d H:i:s'),
                'error' => null,
            ]);

            // Run the command in the background using Process
            $process = new Process([
                'php', 
                base_path('artisan'), 
                'bible:check-words'
            ]);
            
            $process->setTimeout(null); // No timeout
            $process->start(); // Start asynchronously
            
            return response()->json([
                'success' => true,
                'message' => 'Bible word check job started successfully.',
                'pid' => $process->getPid()
            ]);
        } catch (\Exception $e) {
            $this->updateJobStatus([
                'status' => 'Failed',
                'error' => $e->getMessage(),
                'last_updated' => \Carbon\Carbon::now()->addHours(5)->addMinutes(30)->format('Y-m-d H:i:s')->format('Y-m-d H:i:s')
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to start job: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reset the job status.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetJob()
    {
        if (!has_permission('cron_job_menu', 'update')) {
            return response()->json([
                'error' => true,
                'message' => 'Permission denied. You are not authorized to perform this action.'
            ], 400);
        }
        if(!has_module_access('cron_job_menu')) {
            return response()->json([
                'error' => true,
                'message' => 'Permission denied. You are not authorized to perform this action.'
            ], 400);
        }
        try {
            if (File::exists($this->statusFilePath)) {
                File::delete($this->statusFilePath);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Job status reset successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to reset job status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Stop the running job.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function stopJob()
    {
        if (!has_permission('cron_job_menu', 'delete')) {
            return response()->json([
                'error' => true,
                'message' => 'Permission denied. You are not authorized to perform this action.'
            ], 400);
        }
        if(!has_module_access('cron_job_menu')) {
            return response()->json([
                'error' => true,
                'message' => 'Permission denied. You are not authorized to perform this action.'
            ], 400);
        }

        try {
            // Update status to indicate stopping
            $this->updateJobStatus([
                'status' => 'Stopping...',
                'last_updated' => \Carbon\Carbon::now()->addHours(5)->addMinutes(30)->format('Y-m-d H:i:s')
            ]);

            // Note: In a production environment, you might want to implement
            // a more sophisticated way to stop the job, such as using
            // job queues or process management
            
            return response()->json([
                'success' => true,
                'message' => 'Job stop signal sent.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to stop job: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get job status from file
     *
     * @return array
     */
    private function getJobStatus()
    {
        $defaultStatus = [
            'status' => 'Not Started',
            'progress' => 0,
            'current_version' => 'N/A',
            'current_verse_count' => 0,
            'total_verses_in_version' => 0,
            'processed_versions' => 0,
            'total_versions' => 0,
            'last_updated' => 'N/A',
            'error' => null,
        ];

        if (File::exists($this->statusFilePath)) {
            $content = File::get($this->statusFilePath);
            $status = json_decode($content, true);
            
            if (is_array($status)) {
                return array_merge($defaultStatus, $status);
            }
        }
        
        return $defaultStatus;
    }

    /**
     * Update job status in file
     *
     * @param array $data
     * @return void
     */
    private function updateJobStatus($data)
    {
        $currentStatus = $this->getJobStatus();
        $updatedStatus = array_merge($currentStatus, $data);
        
        File::put($this->statusFilePath, json_encode($updatedStatus, JSON_PRETTY_PRINT));
    }

    /**
     * Get job logs (if you want to implement log viewing)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getJobLogs()
    {
        try {
            $logPath = storage_path('logs/laravel.log');
            
            if (!File::exists($logPath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Log file not found.'
                ]);
            }
            
            // Get last 100 lines of log file
            $lines = file($logPath);
            $recentLines = array_slice($lines, -100);
            
            // Filter for Bible word check related logs
            $relevantLogs = array_filter($recentLines, function($line) {
                return strpos($line, 'Bible word check') !== false;
            });
            
            return response()->json([
                'success' => true,
                'logs' => array_values($relevantLogs)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve logs: ' . $e->getMessage()
            ], 500);
        }
    }
}