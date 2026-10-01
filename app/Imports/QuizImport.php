<?php

namespace App\Imports;

use App\Models\Vidukathaigal;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class QuizImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Validate that required keys exist
        $validator = Validator::make($row, [
            'question' => 'required',
            'level' => 'required',
            'answer' => 'required',
            'hints' => 'required',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        $Vidukathaigal = Vidukathaigal::updateOrCreate(
            ['question' => $row['question']], // Unique condition
            [
                'question'         => $row['question'],
                'level'            => $row['level'],
                'answer'           => $row['answer'],
                'hints'            => $row['hints'],
            ]
        );

        return $Vidukathaigal;
    }
}
