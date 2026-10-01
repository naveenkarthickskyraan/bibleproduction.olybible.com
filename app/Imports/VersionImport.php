<?php

namespace App\Imports;

use App\Models\Version;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Auth;

class VersionImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (!has_permission('version_menu', 'import')) {
            abort(403);
        }
        if (!has_module_access('version_menu')) {
            abort(403);
        }

        // Validate that required keys exist
        $validator = Validator::make($row, [
            'version_name' => 'required',
            'status' => 'required|integer',
            'alignment' => 'required|integer',
            'audiotype' => 'required',
            'metakeywords' => 'nullable|string|max:255',
            'metadescription' => 'nullable|string|max:160',
        ], [
            'audiotype.required' => 'Audio Type is Required',
            'alignment.required' => 'Alignment is Required',
            'version_num.required' => 'Version Number is Required',
            'version_num.integer' => 'Version Number must be a Number',
            'status.required' => 'Status is Required',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        // Create the version record
        $version = new Version();
        $version->version_name = $row['version_name'];
        $version->status = $row['status'];
        $version_num = Version::with('version_num')->max('version_num') ;
        $version_num += 1;
        $version->version_num = $version_num;
        $version->alignment = $row['alignment'];
        $version->metadescription = $row['metadescription'] ?? null;
        $version->metakeywords = $row['metakeywords'] ?? null;
        $version->lang_id = $row['lang_id'] ?? null;
        $version->lang = $row['lang'] ?? null;
        $version->audiotype = $row['audiotype'];
        $version->createdby = Auth::guard('admin')->user()->name;
        $version->updatedby = Auth::guard('admin')->user()->name;
        $version->createdid = Auth::guard('admin')->user()->id;
        $version->updatedid = Auth::guard('admin')->user()->id;
        $version->save();

        // Create the associated table
        $tableName = "record" . $version->id;
        if (!Schema::connection('mysql2')->hasTable($tableName)) {
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

        return $version;
    }

    public function headingRow(): int
    {
        return 1; // Assuming the first row contains the headers
    }
}