<?php

namespace App\Http\Controllers\Verse;

use App\Models\Verse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Book;
use App\Models\Version;
use App\Helpers\LogActivity;
use DataTables;
use Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use App\Rules\ExistsInMysql2;

class VerseInfoController extends Controller
{
    public function show(Request $request)
    {
        if (!has_permission('verse_menu', 'read')) {
            abort(403);
        }
        if (!has_module_access('verse_menu')) {
            abort(403);
        }


        if($request->ajax()) {
            $recordId = $request->version_id;
            $verse_infos = collect(); // default empty collection if no records found

            if (isset($recordId) && !empty($recordId)) {
                $versions = Version::where('id', $recordId)->first();

                if ($versions != null) {
                    $connection = DB::connection('mysql2');
                    $tableName = 'record' . $versions->id;

                    try {
                            
                        if (!Schema::connection('mysql2')->hasColumn($tableName, 'deleted_at')) {
                            $connection->statement("ALTER TABLE `$tableName` ADD `deleted_at` INT(11) NOT NULL DEFAULT 0");
                            $connection->statement("ALTER TABLE `$tableName` ADD `is_active` INT(11) NOT NULL DEFAULT 0");
                            // Try initial query
                            $query = $connection->table($tableName)->where('deleted_at', 0);
                                
                            // Handle search filter
                            if ($request->has('search') && !empty($request->search['value'])) {
                                $searchTerm = $request->search['value'];
                                $query->where(function($q) use ($searchTerm) {
                                    $q->where('content', 'like', '%' . $searchTerm . '%')
                                    ->orWhere('verse_num', 'like', '%' . $searchTerm . '%');
                                });
                            }

                            // Handle column-specific filtering
                            if ($request->has('columns')) {
                                foreach ($request->columns as $column) {
                                    if (isset($column['search']['value']) && !empty($column['search']['value'])) {
                                        $searchValue = $column['search']['value'];
                                        switch ($column['data']) {
                                            case 'book_num':
                                                $query->where('book_num', $searchValue);
                                                break;
                                            case 'version_id':
                                                $query->where('version_id', $searchValue);
                                                break;
                                            case 'status':
                                                $query->where('is_active', $searchValue);
                                                break;
                                            case 'created_at':
                                                // Date range filtering example
                                                $dates = explode(' - ', $searchValue);
                                                if (count($dates) == 2) {
                                                    $query->whereBetween('created_at', [
                                                        Carbon::parse($dates[0])->startOfDay(),
                                                        Carbon::parse($dates[1])->endOfDay()
                                                    ]);
                                                }
                                                break;
                                        }
                                    }
                                }
                            }

                            // Handle ordering
                            if ($request->has('order') && count($request->order)) {
                                $columnIndex = $request->order[0]['column'];
                                $columnName = $request->columns[$columnIndex]['data'];
                                $direction = $request->order[0]['dir'];
                                
                                // Map DataTable columns to database columns
                                $orderMap = [
                                    'content' => 'content',
                                    'version_id' => 'version_id',
                                    'book_id' => 'book_num',
                                    'created_at' => 'created_at',
                                    'status' => 'is_active'
                                ];
                                
                                if (isset($orderMap[$columnName])) {
                                    $query->orderBy($orderMap[$columnName], $direction);
                                }
                            }

                            // Get the filtered and ordered results
                            $verse_infos = $query;

                        } else {
                            // Try initial query
                            $query = $connection->table($tableName)->where('deleted_at', 0);
                                
                            // Handle search filter
                            if ($request->has('search') && !empty($request->search['value'])) {
                                $searchTerm = $request->search['value'];
                                $query->where(function($q) use ($searchTerm) {
                                    $q->where('content', 'like', '%' . $searchTerm . '%')
                                    ->orWhere('verse_num', 'like', '%' . $searchTerm . '%');
                                });
                            }

                            // Handle column-specific filtering
                            if ($request->has('columns')) {
                                foreach ($request->columns as $column) {
                                    if (isset($column['search']['value']) && !empty($column['search']['value'])) {
                                        $searchValue = $column['search']['value'];
                                        switch ($column['data']) {
                                            case 'book_num':
                                                $query->where('book_num', $searchValue);
                                                break;
                                            case 'version_id':
                                                $query->where('version_id', $searchValue);
                                                break;
                                            case 'status':
                                                $query->where('is_active', $searchValue);
                                                break;
                                            case 'created_at':
                                                // Date range filtering example
                                                $dates = explode(' - ', $searchValue);
                                                if (count($dates) == 2) {
                                                    $query->whereBetween('created_at', [
                                                        Carbon::parse($dates[0])->startOfDay(),
                                                        Carbon::parse($dates[1])->endOfDay()
                                                    ]);
                                                }
                                                break;
                                        }
                                    }
                                }
                            }

                            // Handle ordering
                            if ($request->has('order') && count($request->order)) {
                                $columnIndex = $request->order[0]['column'];
                                $columnName = $request->columns[$columnIndex]['data'];
                                $direction = $request->order[0]['dir'];
                                
                                // Map DataTable columns to database columns
                                $orderMap = [
                                    'content' => 'content',
                                    'version_id' => 'version_id',
                                    'book_id' => 'book_num',
                                    'created_at' => 'created_at',
                                    'status' => 'is_active'
                                ];
                                
                                if (isset($orderMap[$columnName])) {
                                    $query->orderBy($orderMap[$columnName], $direction);
                                }
                            }

                            // Get the filtered and ordered results
                            $verse_infos = $query;

                        }
                    } catch (QueryException $e) {
                        // Check if error is due to missing 'deleted_at' column
                        if (str_contains($e->getMessage(), "Unknown column 'deleted_at'")) {

                            // Add the missing columns to the table
                            $connection->statement("ALTER TABLE `$tableName` ADD `deleted_at` INT(11) NOT NULL DEFAULT 0");
                            $connection->statement("ALTER TABLE `$tableName` ADD `is_active` INT(11) NOT NULL DEFAULT 0");

                            // Retry the query after adding the columns
                            $verse_infos = $connection->table($tableName)->where('deleted_at', 0);

                        } else {
                            // For other errors, rethrow it
                            throw $e;
                        }
                    }
                }
            }
            else {
                $bookList = Book::where('title', '!=', '')
                    ->select(DB::raw('MAX(version_id) as version_id'), 'version_id', DB::raw('COUNT(*) as sub_category_count'))
                    ->groupBy('version_id')
                    ->orderBy('sub_category_count', 'desc')
                    ->pluck('version_id');

                $versions = Version::whereIn('id', $bookList)->first();

                if($versions != null) {
                    $connection = DB::connection('mysql2');
                    $tableName = 'record' . $versions->id;

                    try {
                        // Initial query builder
                        $query = $connection->table($tableName)->where('deleted_at', 0);

                        // Handle search filter
                        if ($request->has('search') && !empty($request->search['value'])) {
                            $searchTerm = $request->search['value'];
                            $query->where(function($q) use ($searchTerm) {
                                $q->where('content', 'like', '%' . $searchTerm . '%')
                                ->orWhere('verse_num', 'like', '%' . $searchTerm . '%');
                            });
                        }

                        // Handle column-specific filtering
                        if ($request->has('columns')) {
                            foreach ($request->columns as $column) {
                                if (isset($column['search']['value']) && !empty($column['search']['value'])) {
                                    $searchValue = $column['search']['value'];
                                    switch ($column['data']) {
                                        case 'book_num':
                                            $query->where('book_num', $searchValue);
                                            break;
                                        case 'version_id':
                                            $query->where('version_id', $searchValue);
                                            break;
                                        case 'status':
                                            $query->where('is_active', $searchValue);
                                            break;
                                        case 'created_at':
                                            // Date range filtering example
                                            $dates = explode(' - ', $searchValue);
                                            if (count($dates) == 2) {
                                                $query->whereBetween('created_at', [
                                                    Carbon::parse($dates[0])->startOfDay(),
                                                    Carbon::parse($dates[1])->endOfDay()
                                                ]);
                                            }
                                            break;
                                    }
                                }
                            }
                        }

                        // Handle ordering
                        if ($request->has('order') && count($request->order)) {
                            $columnIndex = $request->order[0]['column'];
                            $columnName = $request->columns[$columnIndex]['data'];
                            $direction = $request->order[0]['dir'];
                            
                            // Map DataTable columns to database columns
                            $orderMap = [
                                'content' => 'content',
                                'version_id' => 'version_id',
                                'book_id' => 'book_num',
                                'created_at' => 'created_at',
                                'status' => 'is_active'
                            ];
                            
                            if (isset($orderMap[$columnName])) {
                                $query->orderBy($orderMap[$columnName], $direction);
                            }
                        }

                        // Get the filtered and ordered results
                        $verse_infos = $query;

                    } catch (QueryException $e) {
                        // Handle missing column errors
                        if (str_contains($e->getMessage(), "Unknown column 'deleted_at'")) {
                            // Check and add columns only if they don't exist
                            $columns = $connection->getSchemaBuilder()->getColumnListing($tableName);

                            if (!in_array('deleted_at', $columns)) {
                                $connection->statement("ALTER TABLE `$tableName` ADD `deleted_at` INT(11) NOT NULL DEFAULT 0");
                            }

                            if (!in_array('is_active', $columns)) {
                                $connection->statement("ALTER TABLE `$tableName` ADD `is_active` INT(11) NOT NULL DEFAULT 0");
                            }

                            // Retry the query after fixing the table
                            $verse_infos = $connection->table($tableName)->where('deleted_at', 0);
                        } else {
                            // Rethrow any other DB errors
                            throw $e;
                        }
                    }
                }
            }

            return DataTables::of($verse_infos)
                ->addColumn('content', function ($item) {
                    return '<div id="'.$item->id.'">'.htmlspecialchars($item->content).'</div>';
                })
                ->addColumn('version_id', function ($item) {
                    return $item->version_id != null ? Version::find($item->version_id)->version_name : "";
                })
                ->addColumn('book_id', function ($item) {
                    return $item->book_num != null ? Book::where("version_id",$item->version_id)->where("book_num",$item->book_num)->first()->title : "";
                })
                ->addColumn('created_at', function ($item) {
                    $date = \Carbon\Carbon::parse($item->created_at)->addHours(5)->addMinutes(30);
                    return '<div class="date-info">
                                <span class="fw-semibold">'.$date->format('D d, M Y').'</span><br>
                                <span class="text-muted">'.$date->format('h:i A').'</span>
                            </div>';
                })
                ->addColumn('status', function ($item) {
                    return $item->is_active == '0' ? 
                        '<span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span>' : 
                        '<span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i> Inactive</span>';
                })
                ->addColumn('action', function ($item) {
                    $editUrl   = url("admin/edit_verse/".$item->id)."?version_id=".$item->version_id;
                    $deleteUrl = url("admin/delete_verse/".$item->id)."?version_id=".$item->version_id;

                    return '<div class="btn-group">
                                <form action="'.$editUrl.'" method="POST">'.csrf_field().'
                                    <button  type="submit" class="btn btn-icon btn-circle btn-sm btn-outline-primary" style="background: #7367EF !important;border-color:#7367EFcf;color:#ffffff !important;">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </form>
                                <form  id="form_submit_'.$item->id.'"   action="'.$deleteUrl.'" method="POST" style="padding-left:5px;">'.csrf_field().'
                                    <input id="disable_'.$item->id.'" type="hidden" name="ad_app_type" class="form-control" />
                                    <button type="button" class="btn btn-icon btn-circle btn-sm btn-outline-danger" onclick="return validateform('.$item->id.')" style="background: #EE4B2B;border-color:#EE4B2B;color:#ffffff !important">
                                        <i class="fa fa-trash-can-arrow-up"></i>
                                    </button>
                                </form>
                            </div>';
                })
                ->addColumn('status_update', function ($items) {
                    $statusUpdateUrl = url('admin/verse_status_update');
                    $statusText = $items->is_active == '0' ? 'Enable' : 'Disable';
                    $statusValue = $items->is_active == '0' ? '0' : '1';
                    if($statusValue == 1) {
                        return '<center><form action="'.$statusUpdateUrl.'" method="POST">'.
                                csrf_field().
                                '<input type="hidden" name="verse_id" value="'.$items->id.'">'.
                                ($items->is_active == '0' ? '<input type="hidden" name="status" value="0">' : '<input type="hidden" name="status" value="1">').
                                '<button type="submit" data-toggle="tooltip" data-original-title="'.$statusText.'" id="status_btn" name="status_btn" title="" class="btn_status btn btn-success btn-sm '.($items->is_active == '0' ? 'enable' : '').'" style="background: #ffad46!important;border-color: #ffad46!important;color: #fff!important;">
                                    <i class="fa fa-solid fa-ban"></i>
                                </button>
                            </form></center>';
                    } else {
                        return '<center><form action="'.$statusUpdateUrl.'" target="_top" method="POST">'.
                                    csrf_field().
                                    '<input type="hidden" name="verse_id" value="'.$items->id.'">'.
                                    ($items->is_active == '0' ? '<input type="hidden" name="status" value="0">' : '<input type="hidden" name="status" value="1">').
                                    '<button type="submit" data-toggle="tooltip" data-original-title="'.$statusText.'" id="status_btn" name="status_btn" title="" class="btn_status btn btn-success btn-sm '.($items->is_active == '0' ? 'enable' : '').'" >
                                        <i class="fa fa-solid fa-circle"></i>
                                    </button>
                                </form></center>';
                    }
                })
                ->filterColumn('book_id', function($query, $keyword) {
                    // Implement book title filtering if needed
                    // This would require a join with the books table
                })
                ->filterColumn('version_id', function($query, $keyword) {
                    $query->where('version_id', $keyword);
                })
                ->filterColumn('status', function($query, $keyword) {
                    $query->where('is_active', $keyword);
                })
                ->filterColumn('created_at', function($query, $keyword) {
                    // Date range filtering
                    $dates = explode(' - ', $keyword);
                    if (count($dates) == 2) {
                        $query->whereBetween('created_at', [
                            Carbon::parse($dates[0])->startOfDay(),
                            Carbon::parse($dates[1])->endOfDay()
                        ]);
                    }
                })
                ->rawColumns(['book_id','content','version_id','verse_num', 'created_at', 'status', 'action', 'status_update'])
                ->make(true);
        }

        $bookList = Book::where('title', '!=', '')
                ->select(\DB::raw('MAX(version_id) as version_id'), 'version_id', \DB::raw('COUNT(*) as sub_category_count'))
                ->groupBy('version_id')
                ->orderBy('sub_category_count', 'desc')
                ->pluck('version_id');

        $versions = Version::whereIn('id', $bookList)->get();
        $verseIdFirst = Version::whereIn('id', $bookList)->first();
        if (isset($request->version_id) && !empty($request->version_id)) {
            $verseIdFirst = Version::where('id', $request->version_id)->first();
        }

        return view('admin.version.verse.verse_list', compact('versions','verseIdFirst'));

    }

    function Add_list()
    {
        if (!has_permission('verse_menu', 'create')) {
            abort(403);
        }
        if (!has_module_access('verse_menu')) {
            abort(403);
        }
        LogActivity::addToLog();
    
        $versions  = Version::where('deleted_at',0)->get();
        return view('admin.version.verse.add_verse', compact('versions'));

    }

    public function active(Request $request)
    {
        if (!has_permission('verse_menu', 'status')) {
            abort(403);
        }

        if (!has_module_access('verse_menu')) {
            abort(403);
        }

        LogActivity::addToLog();

        $cat_id = $request->verse_id;
        $status = $request->status;
        if($status == 0)
        {
            $app_active = Verse::find($cat_id);
            $app_active->is_active ='1';
            $app_active->save();
            return back()->with('message','Word Disabled Successfully');
        }
        if($status == 1)
        {
            $app_active = Verse::find($cat_id);
            $app_active->is_active ='0';
            $app_active->save();
            return back()->with('message','Word Enabled Successfully');
        }
    }

    public function store(Request $request)
    {
        if (!has_permission('verse_menu', 'create')) {
            abort(403);
        }
        if (!has_module_access('verse_menu')) {
            abort(403);
        }

        $validated =  $request->validate([
            'version_id' => ['required', new ExistsInMysql2('versions', 'id')],
            'book_id' => ['required', new ExistsInMysql2('books', 'id')],
            'chapter_id' => 'required',
            'verse_content' => 'required|array|min:1|max:10',
            'verse_content.*' => 'required|string|min:1|max:1000|distinct',
        ], [
            'verse_content.*.required' => 'Each verse content is required',
            'verse_content.*.min' => 'Each verse must be at least 10 characters',
            'verse_content.*.max' => 'Each verse cannot exceed 1000 characters',
            'verse_content.*.distinct' => 'Duplicate verse content is not allowed',
        ]);

        $versionId = $request->version_id;
        $book = Book::findOrFail($request->book_id);
        $bookNum = $book->book_num;
        $chapterNum = $request->chapter_id;
        $tableName = 'record' . $versionId;

        foreach ($request->verse_content as $index => $content) {
            $verseNum = $index;

            // Check if verse exists
            $existing = DB::connection('mysql2')->table($tableName)
                ->where('version_id', $versionId)
                ->where('book_num', $bookNum)
                ->where('chapter_num', $chapterNum)
                ->where('verse_num', $verseNum)
                ->first();

            if ($existing) {
                // Update it
                DB::connection('mysql2')->table($tableName)
                    ->where('id', $existing->id)
                    ->update([
                        'content' => $content,
                        'meta_keyword' => $request->meta_keyword ?? "",
                        'meta_description' => $request->meta_description ?? "",
                        'version_num' => $request->version_num ?? 0,
                        'uploadedid' => 2,
                        'status' => 0,
                    ]);
            } else {
                // Insert new
                DB::connection('mysql2')->table($tableName)
                    ->insert([
                        'version_id' => $versionId,
                        'book_num' => $bookNum,
                        'chapter_num' => $chapterNum - 1,
                        'verse_num' => $verseNum,
                        'content' => $content,
                        'meta_keyword' => $request->meta_keyword ?? "",
                        'meta_description' => $request->meta_description ?? "",
                        'version_num' => $request->version_num ?? 0,
                        'uploadedid' => 2,
                        'status' => 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
            }
        }

        LogActivity::addToLog();

        return back()->with('message', 'Verse(s) Added/Updated Successfully');
    }


    public function delete(Request $request, $id)
    {
        if (!has_permission('verse_menu', 'delete')) {
            abort(403);
        }
        if (!has_module_access('verse_menu')) {
            abort(403);
        }

        LogActivity::addToLog();

        $Q1 = Verse::find($id);
        $Q1->deleted_at = '1';
        $Q1->save();
        return back()->with('message','Delete Record Successfully');

    }

    public function EditCategory(Request $request,$id)
    {
        if (!has_permission('verse_menu', 'update')) {
            abort(403);
        }
        if (!has_module_access('verse_menu')) {
            abort(403);
        }
        
        try{

            $versionId = $request->version_id;
            $tableName = 'record' . $versionId;

            $verse = DB::connection('mysql2')->table($tableName)
                    ->where('id', $id)
                    ->first();
            
            
            $book = Book::where('version_id',$versionId)->where('deleted_at',0)->get();
            $bookNum = Book::where('version_id',$versionId)->where('book_num',$verse->book_num)->where('deleted_at',0)->first();
            return view('admin.version.verse.edit_verse_list', compact('verse','book','bookNum'));

        } catch(\Exception $e){
            abort(403);
        }
    }

    public function EditCatList(Request $request, $id)
    {
        if (!has_permission('verse_menu', 'update')) {
            abort(403);
        }
        if (!has_module_access('verse_menu')) {
            abort(403);
        }

        $validated              = $request->validate([
            'version_id'        => 'required',
            'book_id'           => ['required', new ExistsInMysql2('books', 'id')],
            'chapter_id'        => 'required',
            'verse_num'         => 'required|integer',
            'content'           => 'required',
            'metadescription'   => 'nullable|string|max:160',
            'metakeywords'      => 'nullable|string|max:255',
        ]);

        $versionId = $request->version_id;
        $book = Book::findOrFail($request->book_id);
        $bookNum = $book->book_num;
        $bookId = $request->book_id;
        $chapterNum = $request->chapter_id;
        $verseNum = $request->verse_num;
        $content = $request->content;
        $metaDescription = $request->metadescription;
        $metaKeywords = $request->metakeywords;

        $tableName = 'record' . $versionId;

        // Check if verse exists
        $verse = DB::connection('mysql2')->table($tableName)->where('id', $id)->first();
        if (!$verse) {
            return back()->with('error', 'Verse not found.');
        }

        // Update the verse
        DB::connection('mysql2')->table($tableName)
            ->where('id', $id)
            ->update([
                'version_id'      => $versionId,
                'book_id'         => $bookId,
                'book_num'        => $bookNum,
                'chapter_num'     => $chapterNum - 1,
                'verse_num'       => $verseNum,
                'content'         => $content,
                'meta_description'=> $metaDescription,
                'meta_keyword'    => $metaKeywords,
                'updated_at'      => now(),
            ]);

        LogActivity::addToLog();

        return redirect()->to(url('admin/verse_list') . '#' . $id)
            ->with('message', 'Verse Edited successfully!');
    }


}
