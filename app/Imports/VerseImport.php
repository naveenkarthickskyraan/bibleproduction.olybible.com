<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Events\AfterImport;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Added for explicit Log facade use

class VerseImport implements ToCollection, WithHeadingRow, WithEvents, WithChunkReading
{
    protected $version_id;
    protected $totalRecords = 0;
    protected $addedRecords = 0;
    protected $updatedRecords = 0;
    protected $failedRecords = 0;
    protected $validationErrors = [];
    protected $processedData = []; // This property is not used in the provided code, consider removing if not needed.
    protected $batchSize = 500;
    protected $tableName;
    protected $startTime;
    protected $maxExecutionTime;
    protected $timeBuffer = 10; // Buffer time in seconds before max_execution_time is reached
    protected $progressCallback;

    public function __construct($version_id)
    {
        $this->version_id = $version_id;
        $this->tableName = 'record' . $this->version_id;
        $this->startTime = time();
        $this->maxExecutionTime = $this->getMaxExecutionTime();
        $this->increaseExecutionLimits();
    }

    /**
     * Set a callback function to report import progress.
     *
     * @param callable $callback The callback function.
     * @return void
     */
    public function setProgressCallback(callable $callback)
    {
        $this->progressCallback = $callback;
    }

    /**
     * Get the maximum execution time allowed, capped at 300 seconds.
     *
     * @return int
     */
    protected function getMaxExecutionTime()
    {
        $maxTime = ini_get('max_execution_time');
        // If max_execution_time is 0 (no limit), default to 300 seconds, otherwise take the minimum of configured or 300.
        return $maxTime == 0 ? 300 : min((int)$maxTime, 300);
    }

    /**
     * Increase PHP execution limits for the import process.
     * Sets max_execution_time to 600 seconds and memory_limit to 512MB if current is lower.
     * Cleans output buffer to prevent issues with long running scripts.
     *
     * @return void
     */
    protected function increaseExecutionLimits()
    {
        ini_set('max_execution_time', 600);
        $current_memory = ini_get('memory_limit');
        if ($this->convertToBytes($current_memory) < $this->convertToBytes('512M')) {
            ini_set('memory_limit', '512M');
        }
        // Ensure no output buffering is active that could cause memory issues
        if (ob_get_level()) {
            ob_end_clean();
        }
    }

    /**
     * Converts a PHP ini_get memory value (e.g., '128M', '1G') to bytes.
     *
     * @param string $value The memory limit string.
     * @return int The memory limit in bytes.
     */
    protected function convertToBytes($value)
    {
        $value = trim($value);
        $last = strtolower($value[strlen($value)-1]);
        $value = (int) $value; // Cast to integer for numeric operations
        switch($last) {
            case 'g': $value *= 1024; // Convert GB to MB
            case 'm': $value *= 1024; // Convert MB to KB
            case 'k': $value *= 1024; // Convert KB to Bytes
        }
        return $value;
    }

    /**
     * Checks if the import process is approaching the maximum execution time limit.
     *
     * @return bool True if there's enough time remaining, false otherwise.
     */
    protected function checkExecutionTime()
    {
        $elapsed = time() - $this->startTime;
        return ($elapsed + $this->timeBuffer) < $this->maxExecutionTime;
    }

    /**
     * Specifies the number of rows to read in a single chunk.
     * This is part of Maatwebsite/Excel's WithChunkReading concern.
     *
     * @return int
     */
    public function chunkSize(): int
    {
        return $this->batchSize;
    }

    /**
     * Registers events for the import process.
     * BeforeImport is used to get total rows, AfterImport is used to flash results to session.
     *
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function(BeforeImport $event) {
                // Get total rows from the 'Worksheet' which is typically the default sheet name.
                $this->totalRecords = $event->getReader()->getTotalRows()['Worksheet'] ?? 0;
                if ($this->totalRecords > 0) {
                    $this->totalRecords--; // Subtract 1 for the header row
                }
            },
            AfterImport::class => function(AfterImport $event) {
                // Flash import results to the session for display in the frontend.
                // session()->flash('import_results', [
                //     'total' => $this->totalRecords,
                //     'added' => $this->addedRecords,
                //     'updated' => $this->updatedRecords,
                //     'failed' => $this->failedRecords,
                //     'errors' => $this->validationErrors,
                // ]);
            },
        ];
    }

    /**
     * Processes each collection (chunk) of rows from the Excel file.
     * This is the main method for the ToCollection concern.
     *
     * @param Collection $collection The current chunk of rows.
     * @return void
     */
    public function collection(Collection $collection)
    {
        // Stop if execution time is nearly exceeded
        if (!$this->checkExecutionTime()) {
            session()->flash('import_warning', 'Import stopped due to time limit. Processed: ' . ($this->addedRecords + $this->updatedRecords) . ' records.');
            return;
        }

        // Filter out completely empty rows
        $filteredRows = $collection->filter(function ($row) {
            return !empty(array_filter($row->toArray()));
        });

        if ($filteredRows->isEmpty()) {
            return;
        }

        // Chunk the filtered rows further into smaller batches for processing
        // This inner chunking can help manage memory and transaction size within a larger Excel chunk.
        $chunks = $filteredRows->chunk(250);

        foreach ($chunks as $chunk) {
            // Re-check execution time for each sub-chunk
            if (!$this->checkExecutionTime()) {
                session()->flash('import_warning', 'Import stopped due to time limit. Processed: ' . ($this->addedRecords + $this->updatedRecords) . ' records.');
                break; // Stop processing further chunks
            }

            $this->processChunk($chunk);

            // Force garbage collection to free up memory after processing a chunk
            if (function_exists('gc_collect_cycles')) {
                gc_collect_cycles();
            }

            // Update progress via callback if provided
            if ($this->progressCallback) {
                call_user_func($this->progressCallback, $this->addedRecords + $this->updatedRecords + $this->failedRecords);
            }
        }
    }

    /**
     * Processes a single sub-chunk of rows, performing validation and preparing data for DB operations.
     *
     * @param Collection $chunk The sub-chunk of rows to process.
     * @return void
     */
    protected function processChunk(Collection $chunk)
    {
        $validRows = [];
        $currentRowIndex = $this->addedRecords + $this->updatedRecords + $this->failedRecords + 2;

        foreach ($chunk as $row) {
            $rowArray = $row->toArray();
            
            // Convert numeric values to string format
            if (isset($rowArray['book_num'])) {
                $rowArray['book_num'] = (string)$rowArray['book_num'];
            }
            if (isset($rowArray['chapter_num'])) {
                $rowArray['chapter_num'] = (string)$rowArray['chapter_num'];
            }
            if (isset($rowArray['verse_num'])) {
                $rowArray['verse_num'] = (string)$rowArray['verse_num'];
            }

            $validator = Validator::make($rowArray, [
                'book_num' => 'required|string',
                'chapter_num' => 'required|string', 
                'verse_num' => 'required|string',
                'content' => 'required|string',
            ]);

            if ($validator->fails()) {
                $this->failedRecords++;
                $this->validationErrors[] = [
                    'row' => $currentRowIndex,
                    'errors' => $validator->errors()->all(),
                    'data' => $rowArray
                ];
            } else {
                $validRows[] = [
                    'data' => $rowArray,
                    'row_index' => $currentRowIndex
                ];
            }
            $currentRowIndex++;
        }

        if (empty($validRows)) {
            return;
        }

        try {
            DB::connection('mysql2')->transaction(function () use ($validRows) {
                $this->processBatch($validRows);
            }, 3);
        } catch (\Exception $e) {
            \Log::error('Transaction failed: ' . $e->getMessage());
            $this->failedRecords += count($validRows);
        }
    }

    protected function processBatch($validRows)
    {
        try {
            $lookupConditions = [];
            foreach ($validRows as $rowData) {
                $row = $rowData['data'];
                $lookupConditions[] = [
                    'version_id' => $this->version_id,
                    'book_num' => (string)$row['book_num'], // Ensure string format
                    'chapter_num' => (string)$row['chapter_num'], // Ensure string format
                    'verse_num' => (string)$row['verse_num'] // Ensure string format
                ];
            }
            

            $existingRecords = [];
            if (!empty($lookupConditions)) {
                $query = DB::connection('mysql2')->table($this->tableName);
                
                $query->where(function($q) use ($lookupConditions) {
                    foreach ($lookupConditions as $condition) {
                        $q->orWhere(function($subQ) use ($condition) {
                            $subQ->where('version_id', $condition['version_id'])
                                ->where('book_num', $condition['book_num'])
                                ->where('chapter_num', $condition['chapter_num'])
                                ->where('verse_num', $condition['verse_num']);
                        });
                    }
                });

                $results = $query->get(['id', 'version_id', 'book_num', 'chapter_num', 'verse_num']);
                
                foreach ($results as $record) {
                    $key = "{$record->version_id}|{$record->book_num}|{$record->chapter_num}|{$record->verse_num}";
                    $existingRecords[$key] = $record;
                }
            }

            $insertData = [];
            $updateData = [];
            $now = now();

            foreach ($validRows as $rowData) {
                try {
                    $row = $rowData['data'];
                    $key = "{$this->version_id}|{$row['book_num']}|{$row['chapter_num']}|{$row['verse_num']}";

                    $recordData = [
                        'version_id' => $this->version_id,
                        'book_num' => (string)$row['book_num'], // Ensure string format
                        'chapter_num' => (string)$row['chapter_num'], // Ensure string format
                        'verse_num' => (string)$row['verse_num'], // Ensure string format
                        'content' => $row['content'],
                        'uploadedid' => 2,
                        'status' => 0,
                        'updated_at' => $now,
                        'word_ids'=>""
                    ];

                    if (isset($existingRecords[$key])) {
                        $updateData[] = [
                            'id' => $existingRecords[$key]->id,
                            'data' => $recordData
                        ];
                        $this->updatedRecords++;
                    } else {
                        $insertData[] = array_merge($recordData, [
                            'created_at' => $now
                        ]);
                        $this->addedRecords++;
                    }
                } catch (\Exception $e) {
                    $this->failedRecords++;
                    $this->validationErrors[] = [
                        'row' => $rowData['row_index'],
                        'errors' => [$e->getMessage()],
                        'data' => $row
                    ];
                }
            }
            if (!empty($insertData)) {
                $this->performBulkInsert($insertData);
            }

            if (!empty($updateData)) {
                $this->performBulkUpdate($updateData);
            }

        } catch (\Exception $e) {
            \Log::error('Batch processing error: ' . $e->getMessage());
            $this->failedRecords += count($validRows);
        }
    }

    /**
     * Performs a bulk insert operation for the provided data.
     * Includes a fallback to individual inserts if the bulk operation fails.
     *
     * @param array $insertData Array of data to be inserted.
     * @return void
     */
    protected function performBulkInsert($insertData)
    {
        $chunks = array_chunk($insertData, 100); // Chunk inserts into smaller batches
        foreach ($chunks as $chunk) {
            if (!$this->checkExecutionTime()) {
                session()->flash('import_warning', 'Import stopped due to time limit during insert operations.');
                break;
            }

            try {
                DB::connection('mysql2')->table($this->tableName)->insert($chunk);
            } catch (\Exception $e) {
                Log::error('Bulk insert failed: ' . $e->getMessage(), ['chunk_size' => count($chunk), 'exception' => $e->getTraceAsString()]);
                // If bulk insert fails, attempt individual inserts to find problematic records
                foreach ($chunk as $record) {
                    try {
                        DB::connection('mysql2')->table($this->tableName)->insert($record);
                    } catch (\Exception $e_individual) {
                        Log::error('Individual insert failed: ' . $e_individual->getMessage(), ['record' => $record, 'exception' => $e_individual->getTraceAsString()]);
                        $this->failedRecords++;
                        // Add detailed error for the specific record that failed
                        $this->validationErrors[] = [
                            'row' => 'Unknown (from bulk insert fallback)', // Cannot directly map to original Excel row index here without passing it along
                            'errors' => ['Individual insert failed: ' . $e_individual->getMessage()],
                            'data' => $record
                        ];
                    }
                }
            }

            usleep(1000); // Pause for 1 millisecond to prevent overwhelming the database
        }
    }

    /**
     * Performs a bulk update operation for the provided data.
     * Uses a CASE statement for efficient bulk updates.
     * Includes a fallback to individual updates if the bulk operation fails.
     *
     * @param array $updateData Array of data to be updated, including 'id' and 'data'.
     * @return void
     */
    protected function performBulkUpdate($updateData)
    {
        $chunks = array_chunk($updateData, 50); // Chunk updates into smaller batches
        foreach ($chunks as $chunk) {
            if (!$this->checkExecutionTime()) {
                session()->flash('import_warning', 'Import stopped due to time limit during update operations.');
                break;
            }

            try {
                $cases = [];
                $ids = [];
                // Define all fields that can be updated. Ensure this matches your table schema.
                $fields = ['content', 'book_num', 'chapter_num', 'verse_num', 'uploadedid', 'status', 'updated_at'];

                foreach ($fields as $field) {
                    $cases[$field] = 'CASE id ';
                    foreach ($chunk as $update) {
                        $value = $update['data'][$field] ?? null;
                        // Only include fields that are present and not null in the update data
                        if ($value !== null) {
                            // Quote string values to prevent SQL injection and ensure proper syntax
                            $escapedValue = is_string($value)
                                ? DB::connection('mysql2')->getPdo()->quote($value)
                                : $value;
                            $cases[$field] .= "WHEN {$update['id']} THEN {$escapedValue} ";
                        }
                    }
                    $cases[$field] .= 'END'; // Close the CASE statement for this field
                }

                $ids = array_column($chunk, 'id'); // Get all IDs for the WHERE IN clause
                $setClauses = [];
                foreach ($fields as $field) {
                    // Only add to SET clause if the CASE statement for this field has entries
                    // This prevents empty CASE statements for fields not present in any row's update data
                    if (isset($cases[$field]) && str_contains($cases[$field], 'WHEN')) { // Check if 'WHEN' exists to ensure it's not an empty CASE
                        $setClauses[] = "{$field} = {$cases[$field]}";
                    }
                }

                // Construct the final SQL update statement
                if (!empty($setClauses) && !empty($ids)) {
                    $sql = "UPDATE {$this->tableName} SET " . implode(', ', $setClauses) .
                           " WHERE id IN (" . implode(',', $ids) . ")";

                    DB::connection('mysql2')->statement($sql);
                } else {
                    Log::warning('Skipped bulk update for a chunk due to no fields to update or no IDs.', ['chunk' => $chunk]);
                }

            } catch (\Exception $e) {
                Log::error('Bulk update failed: ' . $e->getMessage(), ['chunk_size' => count($chunk), 'exception' => $e->getTraceAsString()]);

                // Fallback to individual updates if bulk update fails
                foreach ($chunk as $update) {
                    try {
                        DB::connection('mysql2')->table($this->tableName)
                            ->where('id', $update['id'])
                            ->update($update['data']);
                    } catch (\Exception $e_individual) {
                        Log::error('Individual update failed: ' . $e_individual->getMessage(), ['update_data' => $update, 'exception' => $e_individual->getTraceAsString()]);
                        $this->failedRecords++;
                        // Add detailed error for the specific record that failed
                        $this->validationErrors[] = [
                            'row' => $update['row_index'], // Now we can use the stored original row index
                            'errors' => ['Individual update failed: ' . $e_individual->getMessage()],
                            'data' => $update['data']
                        ];
                    }
                }
            }

            usleep(500); // Pause for 0.5 milliseconds
        }
    }

    /**
     * Retrieves the import results after processing.
     *
     * @return array
     */
    public function getResults()
    {
        return [
            'total' => $this->totalRecords,
            'added' => $this->addedRecords,
            'updated' => $this->updatedRecords,
            'failed' => $this->failedRecords,
            'errors' => $this->validationErrors,
            // 'processed_data' is currently not populated, consider if it's needed.
            'processed_data' => $this->processedData,
        ];
    }
}
