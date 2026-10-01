<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Version;
use App\Models\Dictionary\DictionaryInfo;
use App\Models\BaseVerse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;

class NewCheckBibleWords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bible:check-words';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks each verse for specific words and updates the word_ids column with exact case-sensitive matching.';

    /**
     * Path to store session data for console commands
     */
    private $sessionFilePath;

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
        $this->sessionFilePath = storage_path('app/bible_job_status.json');
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $currentStatusOfJob = $this->getJobStatus();
        
        // If no status file exists, initialize it
        if (!empty($currentStatusOfJob) && count($currentStatusOfJob) > 0) {

            $status = $currentStatusOfJob['status'] ?? 'Stopping...';

            switch ($status) {
                case 'Starting...':
                    $this->startJob();
                    break;
                    
                // case 'In Progress':
                //     $this->continueJob();
                //     break;
                    
                case 'Stopping...':
                    case 'Stopped':
                    case 'Failed':
                    case 'Completed':
                    default:
                        $this->info("Job is currently in status: {$status}");
                        if ($status === 'Stopping...') {
                            $this->stopJob();
                        }
                        break;
            }
        }
    }

    /**
     * Initialize job status with default values
     */
    private function initializeJobStatus()
    {
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
    }

    /**
     * Start the job processing
     */
    private function startJob()
    {
        $this->info('Starting Bible word check job...');
        Log::info('Bible word check job started.');

        // Initialize progress tracking in file-based session
        $this->updateJobStatus([
            'status' => 'In Progress',
            'progress' => 0,
            'current_version' => '',
            'current_verse_count' => 0,
            'total_verses_in_version' => 0,
            'processed_versions' => 0,
            'total_versions' => 0,
            'last_updated' => \Carbon\Carbon::now()->addHours(5)->addMinutes(30)->format('Y-m-d H:i:s'),
            'error' => null,
        ]);

        $this->processVersions();
    }

    /**
     * Continue a job that was in progress
     */
    private function continueJob()
    {
        $currentStatus = $this->getJobStatus();
        $this->info("Resuming Bible word check job from previous state...");
        Log::info("Resuming Bible word check job from previous state", $currentStatus);

        $this->processVersions();
    }

    /**
     * Stop the job gracefully
     */
    private function stopJob()
    {
        $this->info('Stopping Bible word check job...');
        Log::info('Bible word check job stopping as requested.');

        $this->updateJobStatus([
            'status' => 'Stopped',
            'last_updated' => \Carbon\Carbon::now()->addHours(5)->addMinutes(30)->format('Y-m-d H:i:s'),
        ]);

        $this->info('Bible word check job stopped successfully.');
    }

    /**
     * Main processing logic for versions
     */
    private function processVersions()
    {
        try {
            $wordsVersionId = DictionaryInfo::groupBy('version_id')
                ->where('deleted_at', 0)
                ->pluck('version_id')->toArray();
                
            $versions = Version::whereIn('id', $wordsVersionId)->where('deleted_at', 0)->get();
            $totalVersions = $versions->count();
            
            $this->updateJobStatus(['total_versions' => $totalVersions]);

            $processedVersions = $this->getJobStatus()['processed_versions'] ?? 0;

            foreach ($versions as $version) {
                // Check if we should stop processing
                if ($this->shouldStopProcessing()) {
                    $this->updateJobStatus([
                        'status' => 'Stopped',
                        'last_updated' => \Carbon\Carbon::now()->addHours(5)->addMinutes(30)->format('Y-m-d H:i:s'),
                    ]);
                    $this->info('Job stopped as requested.');
                    return;
                }

                $processedVersions++;
                $versionTableName = 'record' . $version->id;

                $connection = \DB::connection('mysql2');
                if (!Schema::connection('mysql2')->hasColumn($versionTableName, 'word_ids')) {
                    $connection->statement("ALTER TABLE `$versionTableName` ADD `word_ids` LONGTEXT NOT NULL");
                }

                // Update session with current version being processed
                $this->updateJobStatus([
                    'current_version' => $version->version_name,
                    'processed_versions' => $processedVersions,
                    'last_updated' => \Carbon\Carbon::now()->addHours(5)->addMinutes(30)->format('Y-m-d H:i:s')
                ]);

                $this->info("Bible word check Processing version: {$version->version_name} (Table: {$versionTableName})");
                Log::info("Bible word check Processing version: {$version->version_name} (Table: {$versionTableName})");

                // Check if the dynamic table exists
                if (!Schema::connection('mysql2')->hasTable($versionTableName)) {
                    $this->warn("Table {$versionTableName} does not exist. Skipping this version.");
                    Log::warning("Table {$versionTableName} does not exist. Skipping this version.");
                    continue;
                }

                // Create a dynamic model instance for the current version's table
                $verseModel = BaseVerse::forVersion($version->id);
                $totalVersesInVersion = $verseModel->count();
                
                $this->updateJobStatus([
                    'total_verses_in_version' => $totalVersesInVersion,
                    'current_verse_count' => 0
                ]);

                $currentVerseCount = 0;

                // Chunking to prevent memory issues with large tables
                $verseModel->chunkById(1000, function ($verses) use ($version, $versionTableName, &$currentVerseCount, $totalVersesInVersion) {
                    foreach ($verses as $verse) {
                        // Check if we should stop processing before each verse
                        if ($this->shouldStopProcessing()) {
                            return false; // This will break out of the chunk
                        }

                        $foundWordIds = [];
                        $words = DictionaryInfo::where('version_id', $version->id)->where('deleted_at', 0)->get();
                        
                        foreach ($words as $word) {
                            // Case-sensitive exact word matching using word boundaries
                            if ($this->findExactWord($verse->content, $word->word)) {
                                // Add word ID if not already present
                                if (!in_array($word->id, $foundWordIds)) {
                                    $foundWordIds[] = $word->id;
                                }
                            }
                        }

                        // Get existing word IDs, if any, and merge
                        $existingWordIds = $verse->word_ids ? explode(',', $verse->word_ids) : [];
                        $mergedWordIds = array_unique(array_merge($existingWordIds, $foundWordIds));
                        sort($mergedWordIds); // Keep IDs sorted for consistency
                        
                        // Update the verse if there are changes
                        $newWordIdsString = implode(',', $mergedWordIds);
                        if ($newWordIdsString !== ($verse->word_ids ?? '')) {
                            $verse->word_ids = $newWordIdsString;
                            $verse->save();
                            // Log the update
                            Log::info("Updated verse ID {$verse->id} in {$versionTableName} with word_ids: {$newWordIdsString}");
                        }

                        $currentVerseCount++;

                        // Update session with progress (throttle to avoid excessive writes)
                        if ($currentVerseCount % 100 === 0 || $currentVerseCount === $totalVersesInVersion) {
                            $progressPercentage = ($currentVerseCount / $totalVersesInVersion) * 100;
                            $this->updateJobStatus([
                                'current_verse_count' => $currentVerseCount,
                                'progress' => floor($progressPercentage),
                                'last_updated' => \Carbon\Carbon::now()->addHours(5)->addMinutes(30)->format('Y-m-d H:i:s')
                            ]);
                        }
                    }
                });

                $this->info("Finished Bible word check processing version: {$version->version_name}");
            }

            $this->updateJobStatus([
                'status' => 'Completed',
                'progress' => 100,
                'current_version' => 'N/A',
                'current_verse_count' => 0,
                'total_verses_in_version' => 0,
                'processed_versions' => $totalVersions,
                'total_versions' => $totalVersions,
                'last_updated' => \Carbon\Carbon::now()->addHours(5)->addMinutes(30)->format('Y-m-d H:i:s'),
                'error' => null,
            ]);
            
            $this->info('Bible word check job completed successfully.');
            Log::info('Bible word check job completed successfully.');

        } catch (\Exception $e) {
            $this->error("An error occurred: " . $e->getMessage());
            Log::error("Bible word check job failed: " . $e->getMessage());
            
            $this->updateJobStatus([
                'status' => 'Failed',
                'progress' => 0,
                'current_version' => 'N/A',
                'current_verse_count' => 0,
                'total_verses_in_version' => 0,
                'processed_versions' => 0,
                'total_versions' => 0,
                'last_updated' => \Carbon\Carbon::now()->addHours(5)->addMinutes(30)->format('Y-m-d H:i:s'),
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Check if we should stop processing based on status file
     */
    private function shouldStopProcessing(): bool
    {
        $currentStatus = $this->getJobStatus();
        return $currentStatus['status'] === 'Stopping...';
    }

    /**
     * Find exact word match with case sensitivity
     *
     * @param string $content
     * @param string $word
     * @return bool
     */
    private function findExactWord($content, $word)
    {
        // Use word boundaries to match exact words only (case-sensitive)
        // This will match whole words only, not partial matches
        $pattern = '/\b' . preg_quote($word, '/') . '\b/';
        return preg_match($pattern, $content) === 1;
    }

    /**
     * Update job status in file-based storage (accessible from web)
     *
     * @param array $data
     * @return void
     */
    private function updateJobStatus($data)
    {
        $currentStatus = $this->getJobStatus();
        $updatedStatus = array_merge($currentStatus, $data);
        
        File::put($this->sessionFilePath, json_encode($updatedStatus, JSON_PRETTY_PRINT));
    }

    /**
     * Get current job status from file
     *
     * @return array
     */
    private function getJobStatus()
    {
        if (File::exists($this->sessionFilePath)) {
            $content = File::get($this->sessionFilePath);
            return json_decode($content, true) ?: [];
        }
        
        return [];
    }
}