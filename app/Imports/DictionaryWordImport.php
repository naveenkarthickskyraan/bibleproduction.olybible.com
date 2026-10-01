<?php

namespace App\Imports;

use App\Models\Dictionary\DictionaryInfo;
use App\Models\Version;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class DictionaryWordImport implements ToModel, WithHeadingRow
{
    protected $version_id;

    public function __construct($version_id)
    {
        $this->version_id = $version_id;
    }

    public function model(array $row)
    {
        if (!has_permission('dictionary_menu', 'create')) {
            abort(403);
        }
        if (!has_module_access('dictionary_menu')) {
            abort(403);
        }
        
        // Validate that required keys exist
        $validator = Validator::make($row, [
            'word' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $tableName = "record".$this->version_id;
        $versions = Version::where('id',$this->version_id)->first();

        if(!Schema::connection('mysql2')->hasTable($tableName))
        {
            Schema::connection('mysql2')->create($tableName, function (Blueprint $table) {
                $table->increments('id');
                $table->integer('version_id')->default(0);
                $table->integer('book_id')->default(0);
                $table->text('content')->nullable();
                $table->integer('status')->default(0);
                $table->text('meta_keyword')->nullable();
                $table->text('meta_description')->nullable();
                $table->integer('uploadnotprocess')->default(0);
                $table->integer('version_num')->default(0);
                $table->text('book_num')->nullable();
                $table->text('chapter_num')->nullable();
                $table->text('verse_num')->nullable();
                $table->integer('uploadedid')->default(0);
                $table->integer('chapter_id')->default(0);
                $table->timestamps();
            });

        }

        $DictionaryInfo = DictionaryInfo::updateOrCreate(
            [
                'word' => $row['word'],
                'version_id' => $this->version_id // Include version_id in unique condition
            ],
            [
                'word' => $row['word'],
                'description' => $row['description'],
                'version_name' => $versions->version_name,
                'table_name' => $tableName,
                'version_id' => $this->version_id
            ]
        );

        return $DictionaryInfo;
    }
}