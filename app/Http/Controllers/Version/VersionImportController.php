<?php

namespace App\Http\Controllers\Version;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Imports\VersionImport;
use App\Models\Version;
use Maatwebsite\Excel\Facades\Excel;
use App\Helpers\LogActivity;
use Illuminate\Validation\ValidationException;


class VersionImportController extends Controller
{
    function version_import()
    {
        if (!has_permission('version_menu', 'import')) {
            abort(403);
        }
        if (!has_module_access('version_menu')) {
            abort(403);
        }
        LogActivity::addToLog();

        return view('admin.version.version.import');

    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required',
        ]);

        try {
            Excel::import(new VersionImport, $request->file('file'));            
            LogActivity::addToLog();

            return back()->with('message', 'Version imported successfully!');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong during import: ' . $e->getMessage());
        }
    }
}
