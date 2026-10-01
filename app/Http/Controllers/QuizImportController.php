<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;

use App\Imports\QuizImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Helpers\LogActivity;
use Illuminate\Validation\ValidationException;

class QuizImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        try {
            Excel::import(new QuizImport, $request->file('file'));
            LogActivity::addToLog();

            return back()->with('message', 'Quiz imported successfully!');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong during import: ' . $e->getMessage());
        }
    }
}
