<?php

namespace App\Http\Controllers\Dictionary;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Imports\DictionaryWordImport;
use App\Models\Version;
use App\Models\Book;
use Maatwebsite\Excel\Facades\Excel;
use App\Helpers\LogActivity;
use Illuminate\Validation\ValidationException;


class DictionaryImportController extends Controller
{
    function dictionary_import()
    {
        if (!has_permission('dictionary_menu', 'import')) {
            abort(403);
        }
        if (!has_module_access('dictionary_menu')) {
            abort(403);
        }
        LogActivity::addToLog();

        $bookList = Book::where('title', '!=', '')
                ->select(\DB::raw('MAX(version_id) as version_id'), 'version_id', \DB::raw('COUNT(*) as sub_category_count'))
                ->groupBy('version_id')
                ->orderBy('sub_category_count', 'desc')
                ->pluck('version_id');

        $versions = Version::whereIn('id', $bookList)->get();
        
        return view('admin.quiz.import', compact('versions'));

    }

    public function import(Request $request)
    {
        $request->validate([
            'version_id' => 'required', // assuming you have a dictionary_versions table
            'file' => 'required',
        ]);

        try {
            $import = new DictionaryWordImport($request->version_id);
            Excel::import($import, $request->file('file'));
            
            LogActivity::addToLog();

            return back()->with('message', 'Dictionary words imported successfully!');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong during import: ' . $e->getMessage());
        }
    }
}
