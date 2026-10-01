<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Imports\BookImport;
use App\Models\Book;
use App\Models\Version;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\ValidationException;


class BookImportController extends Controller
{
    function book_import()
    {
        if (!has_permission('book_menu', 'import')) {
            abort(403);
        }
        if (!has_module_access('book_menu')) {
            abort(403);
        }
        $bookList = Book::where('title', '!=', '')
                ->select(\DB::raw('MAX(version_id) as version_id'), 'version_id', \DB::raw('COUNT(*) as sub_category_count'))
                ->groupBy('version_id')
                ->orderBy('sub_category_count', 'desc')
                ->pluck('version_id');

        $versions = Version::orderBy('id','desc')->where('deleted_at',0)->get();

        return view('admin.version.book.import', compact('versions'));

    }

    public function import(Request $request)
    {
        $request->validate([
            'version_id' => 'required', // assuming you have a dictionary_versions table
            'file' => 'required',
        ]);

        try {
            $versionId = $request->version_id;
            $import = new BookImport($versionId);
            Excel::import($import, $request->file('file'));

            $results = $import->getResults();

            return back()->with([
                'message', 'Book imported successfully!',
                'results' => $results
            ]);
            
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong during import: ' . $e->getMessage());
        }
    }
}
