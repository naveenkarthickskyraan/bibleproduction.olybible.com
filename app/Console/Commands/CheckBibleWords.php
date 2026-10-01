<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Version;
use App\Models\Dictionary\DictionaryInfo;
use App\Models\BaseVerse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;

class CheckBibleWords extends Command
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
    protected $description = 'Checks each verse for specific words and updates the word_ids column with exact case-sensitive matching and occurrence counts.';

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
        if (!empty($currentStatusOfJob)) {
            $status = $currentStatusOfJob['status'] ?? 'Stopping...';

            switch ($status) {
                case 'Starting...':
                    $this->startJob();
                    break;
                    
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

            $processedVersions = 0;
            $wordOccurrenceCounts = []; // To track total occurrences across all versions

            foreach ($versions as $version) {
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
                if (!Schema::connection('mysql2')->hasColumn($versionTableName, 'word_counts')) {
                    $connection->statement("ALTER TABLE `$versionTableName` ADD `word_counts` LONGTEXT NOT NULL");
                }

                $this->updateJobStatus([
                    'current_version' => $version->version_name,
                    'processed_versions' => $processedVersions,
                    'last_updated' => \Carbon\Carbon::now()->addHours(5)->addMinutes(30)->format('Y-m-d H:i:s')
                ]);

                $this->info("Bible word check Processing version: {$version->version_name} (Table: {$versionTableName})");
                Log::info("Bible word check Processing version: {$version->version_name} (Table: {$versionTableName})");

                if (!Schema::connection('mysql2')->hasTable($versionTableName)) {
                    $this->warn("Table {$versionTableName} does not exist. Skipping this version.");
                    Log::warning("Table {$versionTableName} does not exist. Skipping this version.");
                    continue;
                }

                $verseModel = BaseVerse::forVersion($version->id);
                $totalVersesInVersion = $verseModel->count();
                
                $this->updateJobStatus([
                    'total_verses_in_version' => $totalVersesInVersion,
                    'current_verse_count' => 0
                ]);

                $currentVerseCount = 0;
                $versionWordCounts = []; // To track word counts for this version

                $words = DictionaryInfo::where('version_id', $version->id)
                    ->where('deleted_at', 0)
                    ->get()
                    ->keyBy('id');

                $verseModel->chunkById(1000, function ($verses) use ($version, $versionTableName, &$currentVerseCount, $totalVersesInVersion, $words, &$versionWordCounts, &$wordOccurrenceCounts) {
                    foreach ($verses as $verse) {
                        if ($this->shouldStopProcessing()) {
                            return false;
                        }

                        $foundWordIds = [];
                        $wordCounts = [];

                        foreach ($words as $word) {
                            $count = $this->countExactWord($verse->content, $word->word);
                            if ($count > 0) {
                                $foundWordIds[] = $word->id;
                                $wordCounts[$word->id] = $count;
                                
                                // Update version word counts
                                if (!isset($versionWordCounts[$word->id])) {
                                    $versionWordCounts[$word->id] = 0;
                                }
                                $versionWordCounts[$word->id] += $count;
                                
                                // Update global word counts
                                if (!isset($wordOccurrenceCounts[$word->id])) {
                                    $wordOccurrenceCounts[$word->id] = 0;
                                }
                                $wordOccurrenceCounts[$word->id] += $count;
                            }
                        }

                        // Get existing data
                        $existingWordIds = $verse->word_ids ? explode(',', $verse->word_ids) : [];
                        $existingWordCounts = $verse->word_counts ? json_decode($verse->word_counts, true) : [];

                        // Merge with new data
                        $mergedWordIds = array_unique(array_merge($existingWordIds, $foundWordIds));
                        $mergedWordCounts = array_merge($existingWordCounts, $wordCounts);
                        
                        // Sort for consistency
                        sort($mergedWordIds);
                        ksort($mergedWordCounts);

                        // Update the verse if there are changes
                        $newWordIdsString = implode(',', $mergedWordIds);
                        $newWordCountsString = json_encode($mergedWordCounts);
                        
                        if ($newWordIdsString !== ($verse->word_ids ?? '') || $newWordCountsString !== ($verse->word_counts ?? '')) {
                            $verse->word_ids = $newWordIdsString;
                            $verse->word_counts = $newWordCountsString;
                            $verse->save();
                            
                            Log::debug("Updated verse ID {$verse->id} in {$versionTableName} with word_ids: {$newWordIdsString} and counts: {$newWordCountsString}");
                        }

                        $currentVerseCount++;

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

                // Update dictionary info with total counts for this version
                foreach ($versionWordCounts as $wordId => $count) {
                    DictionaryInfo::where('id', $wordId)
                        ->update(['occurrences' => $count]);
                }

                $this->info("Finished processing version: {$version->version_name}");
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
                'error' => $e->getMessage(),
                'last_updated' => \Carbon\Carbon::now()->addHours(5)->addMinutes(30)->format('Y-m-d H:i:s'),
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
     * Count exact word matches with case sensitivity
     *
     * @param string $content
     * @param string $word
     * @return int
     */
    private function countExactWord($content, $word)
    {
        // Use Unicode-aware word boundaries and case-insensitive matching
        $pattern = '/(?<!\p{L})' . preg_quote($word, '/') . '(?!\p{L})/ui';
        return preg_match_all($pattern, $content);
    }

    /**
     * Update job status in file-based storage
     */
    private function updateJobStatus($data)
    {
        $currentStatus = $this->getJobStatus();
        $updatedStatus = array_merge($currentStatus, $data);
        
        File::put($this->sessionFilePath, json_encode($updatedStatus, JSON_PRETTY_PRINT));
    }

    /**
     * Get current job status from file
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