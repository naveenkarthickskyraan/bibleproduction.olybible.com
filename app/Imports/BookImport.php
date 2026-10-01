<?php

namespace App\Imports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Events\AfterImport;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class BookImport implements ToModel, WithHeadingRow, WithEvents
{
    protected $version_id;
    protected $totalRecords = 0;
    protected $addedRecords = 0;
    protected $updatedRecords = 0;
    protected $failedRecords = 0;
    protected $validationErrors = [];
    protected $processedData = [];

    public function __construct($version_id)
    {
        $this->version_id = $version_id;
    }

    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function(BeforeImport $event) {
                $this->totalRecords = $event->getReader()->getTotalRows()['Worksheet'] ?? 0;
                $this->totalRecords--; // Subtract 1 for the header row
            },
            AfterImport::class => function(AfterImport $event) {
                // You can process the results here if needed
                session()->flash('import_results', [
                    'total' => $this->totalRecords,
                    'added' => $this->addedRecords,
                    'updated' => $this->updatedRecords,
                    'failed' => $this->failedRecords,
                    'errors' => $this->validationErrors,
                ]);
            },
        ];
    }

    public function model(array $row)
    {
        // Check permissions
        if (!has_permission('book_menu', 'create')) {
            abort(403);
        }
        if (!has_module_access('book_menu')) {
            abort(403);
        }

        // Skip empty rows
        if (empty(array_filter($row))) {
            return null;
        }

        try {
            // Validate that required keys exist and have valid data
            $validator = Validator::make($row, [
                'book_num' => 'required|integer',
                'short_title' => 'required|string|max:255',
                'total_chap_count' => 'required|integer|min:1',
                'title' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                $this->failedRecords++;
                $this->validationErrors[] = [
                    'row' => $this->getCurrentRowIndex(),
                    'errors' => $validator->errors()->all(),
                    'data' => $row
                ];
                return null;
            }

            // Process the record
            $result = Book::updateOrCreate(
                [
                    'book_num' => $row['book_num'],
                    'version_id' => $this->version_id
                ],
                [
                    'book_num' => $row['book_num'],
                    'version_id' => $this->version_id,
                    'title' => $row['title'],
                    'short_title' => $row['short_title'],
                    'total_chap_count' => $row['total_chap_count'],
                ]
            );

            if ($result->wasRecentlyCreated) {
                $this->addedRecords++;
                $this->processedData[] = [
                    'action' => 'added',
                    'data' => $result
                ];
            } else {
                $this->updatedRecords++;
                $this->processedData[] = [
                    'action' => 'updated',
                    'data' => $result
                ];
            }

            return $result;

        } catch (\Exception $e) {
            $this->failedRecords++;
            $this->validationErrors[] = [
                'row' => $this->getCurrentRowIndex(),
                'errors' => [$e->getMessage()],
                'data' => $row
            ];
            return null;
        }
    }

    protected function getCurrentRowIndex()
    {
        // Calculate current row index based on processed records
        return $this->addedRecords + $this->updatedRecords + $this->failedRecords + 1;
    }

    public function getResults()
    {
        return [
            'total' => $this->totalRecords,
            'added' => $this->addedRecords,
            'updated' => $this->updatedRecords,
            'failed' => $this->failedRecords,
            'errors' => $this->validationErrors,
            'processed_data' => $this->processedData,
        ];
    }
}