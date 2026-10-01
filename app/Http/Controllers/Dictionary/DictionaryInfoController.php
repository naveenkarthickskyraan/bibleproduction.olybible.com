<?php

namespace App\Http\Controllers\Dictionary;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Dictionary\DictionaryInfo;
use App\Models\Dictionary\TemplateInfo;
use App\Models\Version;
use App\Models\Book;
use App\Helpers\LogActivity;
use DataTables;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class DictionaryInfoController extends Controller
{
    public function show(Request $request)
    {
        if (!has_permission('dictionary_menu', 'read')) {
            abort(403);
        }
        if (!has_module_access('dictionary_menu')) {
            abort(403);
        }

        $dictionary_infos = DictionaryInfo::where('dictionary_infos.deleted_at',0);

        if($request->ajax()) {
            return DataTables::of($dictionary_infos)
                ->addColumn('word', function ($item) {
                    return '<div id="'.$item->id.'">'.htmlspecialchars($item->word).'</div>';
                })
                ->addColumn('description', function ($item) {
                     return $item->description;
                })
                ->editColumn('version_name', function ($item) {
                    return $item->version_name ? $item->version_name : 'N/A';
                })
                ->addColumn('created_at', function ($item) {
                    $date = $item->created_at->addHours(5)->addMinutes(30);
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
                ->addColumn('action', function ($items) {
                    $editUrl                 = url("admin/edit_dictionary/".$items->id);
                    $deleteUrl               = url("admin/delete_dictionary/".$items->id);

                    return '<div class="btn-group">
                                <form action="'.$editUrl.'" method="POST">'.csrf_field().'
                                    <button  type="submit" class="btn btn-icon btn-circle btn-sm btn-outline-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit App" style="background: #7367EFcf;border-color:#7367EFcf;color:#ffffff !important;"><i class="fa fa-edit"></i></button>
                                </form>
                                <form  id="form_submit_'.$items->id.'"   action="'.$deleteUrl.'" method="POST" style="padding-left:5px;">'.csrf_field().'
                                    <input id="disable_'.$items->id.'" type="hidden" name="ad_app_type"  class="form-control" />
                                    <button  type="button" class="btn btn-icon btn-circle btn-sm btn-outline-danger"  onclick="return validateform('.$items->id.')"  data-bs-toggle="tooltip" data-bs-placement="top" title="Delete App" style="background: #EE4B2B;border-color:#EE4B2B;color:#ffffff !important"><i class="fa fa-trash-can-arrow-up"></i></button>
                                </form>
                            </div>';
                })
                ->addColumn('status_update', function ($items) {
                    $statusUpdateUrl = url('admin/dictionary_status_update');
                    $statusText = $items->is_active == '0' ? 'Enable' : 'Disable';
                    $statusValue = $items->is_active == '0' ? '0' : '1';
                    if($statusValue == 1)
                    {
                        return '<center><form action="'.$statusUpdateUrl.'" method="POST">'.
                                csrf_field().
                                '<input type="hidden" name="dictionary_id" value="'.$items->id.'">'.
                                ($items->is_active == '0' ? '<input type="hidden" name="status" value="0">' : '<input type="hidden" name="status" value="1">').
                                '<button type="submit" data-toggle="tooltip" data-original-title="'.$statusText.'" id="status_btn" name="status_btn" title="" class="btn_status btn btn-success btn-sm '.($items->is_active == '0' ? 'enable' : '').'" style="background: #ffad46!important;border-color: #ffad46!important;color: #fff!important;">
                                    <i class="fa fa-solid fa-ban"></i>
                                </button>
                            </form></center>';
                    }else{

                        return '<center><form action="'.$statusUpdateUrl.'" target="_top" method="POST">'.
                                    csrf_field().
                                    '<input type="hidden" name="dictionary_id" value="'.$items->id.'">'.
                                    ($items->is_active == '0' ? '<input type="hidden" name="status" value="0">' : '<input type="hidden" name="status" value="1">').
                                    '<button type="submit" data-toggle="tooltip" data-original-title="'.$statusText.'" id="status_btn" name="status_btn" title="" class="btn_status btn btn-success btn-sm '.($items->is_active == '0' ? 'enable' : '').'" >
                                        <i class="fa fa-solid fa-circle"></i>
                                    </button>
                                </form></center>';
                    }
                })
                ->rawColumns(['version_name','word','description', 'created_at', 'status', 'action', 'status_update'])
                ->filter(function ($query) use ($request) {
                    if ($request->has('search') && $keyword = $request->get('search')['value']) {
                        $query->where(function($q) use ($keyword) {
                            $q->where('word', 'like', "%{$keyword}%")
                            ->orWhere('description', 'like', "%{$keyword}%")
                            ->orWhereDate('created_at', 'like', "%{$keyword}%")
                            ->orWhereIn('version_id', function($subQuery) use ($keyword) {
                                $subQuery->select('id')
                                        ->from(\DB::connection('mysql2')->table('versions'))
                                        ->where('version_name', 'like', "%{$keyword}%");
                            });
                        });
                    }
                })
                ->make(true);
        }

        return view('admin.dictionary.dictionary.dictionary_list');

    }

    function Add_list()
    {
        if (!has_permission('dictionary_menu', 'create')) {
            abort(403);
        }
        if (!has_module_access('dictionary_menu')) {
            abort(403);
        }
        LogActivity::addToLog();

        $tempInfo = TemplateInfo::where('deleted_at',0)->get();

        $bookList = Book::where('title', '!=', '')
                ->select(\DB::raw('MAX(version_id) as version_id'), 'version_id', \DB::raw('COUNT(*) as sub_category_count'))
                ->groupBy('version_id')
                ->orderBy('sub_category_count', 'desc')
                ->pluck('version_id');

        $versions = Version::whereIn('id', $bookList)->get();
        
        return view('admin.dictionary.dictionary.add_dictionary', compact('tempInfo','versions'));

    }

    public function active(Request $request)
    {
        if (!has_permission('dictionary_menu', 'status')) {
            abort(403);
        }

        if (!has_module_access('dictionary_menu')) {
            abort(403);
        }

        LogActivity::addToLog();

        $cat_id = $request->dictionary_id;
        $status = $request->status;
        if($status == 0)
        {
            $app_active = DictionaryInfo::find($cat_id);
            $app_active->is_active ='1';
            $app_active->save();
            return back()->with('message','Word Disabled Successfully');
        }
        if($status == 1)
        {
            $app_active = DictionaryInfo::find($cat_id);
            $app_active->is_active ='0';
            $app_active->save();
            return back()->with('message','Word Enabled Successfully');
        }
    }

    public function store(Request $request)
    {
        if (!has_permission('dictionary_menu', 'create')) {
            abort(403);
        }
        if (!has_module_access('dictionary_menu')) {
            abort(403);
        }

        $validated = $request->validate([
            'word'         => 'required|string|max:255',
            'description'  => 'required|string',
            'version_id'  => 'required|string',
        ]);

        // ✅ Save to database
        $dictionary = new DictionaryInfo();
        $dictionary->word        = $validated['word'] ?? "";
        $dictionary->description = $validated['description'] ?? "";
        $dictionary->version_id = $validated['version_id'] ?? "";

        if ($validated['version_id']) {
            $tableName = "record".$validated['version_id'];
            $versions = Version::where('id',$validated['version_id'])->first();
            $dictionary->version_name = $versions->version_name;

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

                $dictionary->table_name = $tableName;
            }else{
                $dictionary->table_name = $tableName;
            }
        }
        

        $dictionary->save();
        LogActivity::addToLog();

        return back()->with('message','Word Added Successfully');

    }

    public function delete(Request $request, $id)
    {
        if (!has_permission('dictionary_menu', 'delete')) {
            abort(403);
        }
        if (!has_module_access('dictionary_menu')) {
            abort(403);
        }

        LogActivity::addToLog();

        $Q1 = DictionaryInfo::find($id);
        $Q1->deleted_at = '1';
        $Q1->save();
        return back()->with('message','Delete Record Successfully');

    }

    public function EditCategory($id)
    {
        if (!has_permission('dictionary_menu', 'update')) {
            abort(403);
        }
        if (!has_module_access('dictionary_menu')) {
            abort(403);
        }

        $edit = DictionaryInfo::find($id);
        $tempInfo = TemplateInfo::where('deleted_at',0)->get();
        
        $bookList = Book::where('title', '!=', '')
                ->select(\DB::raw('MAX(version_id) as version_id'), 'version_id', \DB::raw('COUNT(*) as sub_category_count'))
                ->groupBy('version_id')
                ->orderBy('sub_category_count', 'desc')
                ->pluck('version_id');

        $versions = Version::whereIn('id', $bookList)->get();

        return view('admin.dictionary.dictionary.edit_dictionary_list', compact('edit','tempInfo','versions'));

    }

    public function EditCatList(Request $request, $id)
    {
        if (!has_permission('dictionary_menu', 'update')) {
            abort(403);
        }
        if (!has_module_access('dictionary_menu')) {
            abort(403);
        }

        $validated         = $request->validate([
            'word'         => 'required|string|max:255',
            'description'  => 'required|string',
            'version_id'   => 'required|string',
        ]);

        // Find existing record
        $dictionary = DictionaryInfo::findOrFail($id);

        // ✅ Update database record
        $dictionary->word        = $validated['word'] ?? "";
        $dictionary->description = $validated['description'] ?? "";
        $dictionary->version_id = $validated['version_id'] ?? "";

        if ($validated['version_id']) {
            $tableName = "record".$validated['version_id'];
            $versions = Version::where('id',$validated['version_id'])->first();
            $dictionary->version_name = $versions->version_name;

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

                $dictionary->table_name = $tableName;
            }else{
                $dictionary->table_name = $tableName;
            }
        }
        
        $dictionary->save();
        LogActivity::addToLog();

        return redirect()->to(url('admin/dictionary_list') . '#' . $dictionary->id)
                 ->with('message', 'DictionaryInfo Edited successfully!');

    }

}
