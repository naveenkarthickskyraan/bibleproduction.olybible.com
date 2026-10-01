<?php

namespace App\Http\Controllers\Version;

use App\Models\Version;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Lang;
use App\Helpers\LogActivity;
use DataTables;
use Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;


class VersionInfoController extends Controller
{
    public function show(Request $request)
    {
        if (!has_permission('version_menu', 'read')) {
            abort(403);
        }
        if (!has_module_access('version_menu')) {
            abort(403);
        }

        $version_infos = Version::where('deleted_at',0);

        if($request->ajax()) {
            return DataTables::of($version_infos)
                ->addColumn('version_name', function ($item) {
                    return '<div id="'.$item->id.'">'.htmlspecialchars($item->version_name).'</div>';
                })
                ->addColumn('version_num', function ($item) {
                     return $item->version_num;
                })
                ->addColumn('lang', function ($item) {
                    return $item->lang ? $item->lang : 'N/A';
                })
                ->addColumn('alignment', function ($item) {
                    return $item->alignment == 1 ? "Left to Right (LTR)" : 'Right to Left (RTL)';
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
                        '<span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Enabled</span>' : 
                        '<span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i>Disabled</span>';
                })
                ->addColumn('action', function ($items) {
                    $editUrl                 = url("admin/edit_version/".$items->id);
                    $deleteUrl               = url("admin/delete_version/".$items->id);

                    return '<div class="btn-group">
                                <form action="'.$editUrl.'" method="POST">'.csrf_field().'
                                    <button  type="submit" class="btn btn-icon btn-circle btn-sm btn-outline-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit App" style="background: #7367EF !important;border-color:#7367EFcf;color:#ffffff !important;"><i class="fa fa-edit"></i></button>
                                </form>
                                <form  id="form_submit_'.$items->id.'"   action="'.$deleteUrl.'" method="POST" style="padding-left:5px;">'.csrf_field().'
                                    <input id="disable_'.$items->id.'" type="hidden" name="ad_app_type"  class="form-control" />
                                    <button  type="button" class="btn btn-icon btn-circle btn-sm btn-outline-danger"  onclick="return validateform('.$items->id.')"  data-bs-toggle="tooltip" data-bs-placement="top" title="Delete App" style="background: #EE4B2B;border-color:#EE4B2B;color:#ffffff !important"><i class="fa fa-trash-can-arrow-up"></i></button>
                                </form>
                            </div>';
                })
                ->addColumn('status_update', function ($items) {
                    $statusUpdateUrl = url('admin/version_status_update');
                    $statusText = $items->is_active == '0' ? 'Enable' : 'Disable';
                    $statusValue = $items->is_active == '0' ? '0' : '1';
                    if($statusValue == 1)
                    {
                        return '<center><form action="'.$statusUpdateUrl.'" method="POST">'.
                                csrf_field().
                                '<input type="hidden" name="version_id" value="'.$items->id.'">'.
                                ($items->is_active == '0' ? '<input type="hidden" name="status" value="0">' : '<input type="hidden" name="status" value="1">').
                                '<button type="submit" data-toggle="tooltip" data-original-title="'.$statusText.'" id="status_btn" name="status_btn" title="" class="btn_status btn btn-success btn-sm '.($items->is_active == '0' ? 'enable' : '').'" style="background: #ffad46!important;border-color: #ffad46!important;color: #fff!important;">
                                     <i class="fa fa-solid fa-circle"></i>
                                </button>
                            </form></center>';
                    }else{

                        return '<center><form action="'.$statusUpdateUrl.'" target="_top" method="POST">'.
                                    csrf_field().
                                    '<input type="hidden" name="version_id" value="'.$items->id.'">'.
                                    ($items->is_active == '0' ? '<input type="hidden" name="status" value="0">' : '<input type="hidden" name="status" value="1">').
                                    '<button type="submit" data-toggle="tooltip" data-original-title="'.$statusText.'" id="status_btn" name="status_btn" title="" class="btn_status btn btn-success btn-sm '.($items->is_active == '0' ? 'enable' : '').'" >
                                        <i class="fa fa-solid fa-circle"></i>
                                    </button>
                                </form></center>';
                    }
                })
                
                ->orderColumn('version_name', function ($query, $order) {
                    $query->orderBy('version_name', $order);
                })
                ->orderColumn('version_num', function ($query, $order) {
                    $query->orderBy('version_num', $order);
                })
                ->orderColumn('lang', function ($query, $order) {
                    $query->orderBy('lang', $order);
                })
                ->orderColumn('alignment', function ($query, $order) {
                    $query->orderBy('alignment', $order);
                })
                ->orderColumn('created_at', function ($query, $order) {
                    $query->orderBy('created_at', $order);
                })
                ->orderColumn('status', function ($query, $order) {
                    $query->orderBy('is_active', $order);
                })
                ->filterColumn('version_name', function($query, $keyword) {
                    $query->where('version_name', 'like', "%{$keyword}%");
                })
                ->filterColumn('version_num', function($query, $keyword) {
                    $query->where('version_num', 'like', "%{$keyword}%");
                })
                ->filterColumn('lang', function($query, $keyword) {
                    $query->where('lang', 'like', "%{$keyword}%");
                })
                ->filterColumn('alignment', function($query, $keyword) {
                    $alignmentValue = str_contains(strtolower($keyword), 'ltr') ? 1 : 
                                    (str_contains(strtolower($keyword), 'rtl') ? 0 : null);
                    if ($alignmentValue !== null) {
                        $query->where('alignment', $alignmentValue);
                    }
                })
                ->filterColumn('created_at', function($query, $keyword) {
                    $query->whereDate('created_at', 'like', "%{$keyword}%");
                })
                ->filterColumn('status', function($query, $keyword) {
                    $statusValue = str_contains(strtolower($keyword), 'enabled') ? 0 : 
                                (str_contains(strtolower($keyword), 'disabled') ? 1 : 0);
                    if ($statusValue !== null) {
                        $query->where('is_active', $statusValue);
                    }
                })
                ->rawColumns(['alignment','version_name','lang','version_num', 'created_at', 'status', 'action', 'status_update'])
                ->make(true);
        }

        return view('admin.version.version.version_list');

    }

    function Add_list()
    {
        if (!has_permission('version_menu', 'create')) {
            abort(403);
        }
        if (!has_module_access('version_menu')) {
            abort(403);
        }
        LogActivity::addToLog();
        
        $lang = Lang::all();
        $version_num = Version::with('version_num')->max('version_num') ;
        $version_num += 1;

        return view('admin.version.version.add_version', compact('lang','version_num'));

    }

    public function active(Request $request)
    {
        if (!has_permission('version_menu', 'status')) {
            abort(403);
        }

        if (!has_module_access('version_menu')) {
            abort(403);
        }

        LogActivity::addToLog();

        $cat_id = $request->version_id;
        $status = $request->status;
        if($status == 0)
        {
            $app_active = Version::find($cat_id);
            $app_active->is_active ='1';
            $app_active->save();
            return back()->with('message','Word Disabled Successfully');
        }
        if($status == 1)
        {
            $app_active = Version::find($cat_id);
            $app_active->is_active ='0';
            $app_active->save();
            return back()->with('message','Word Enabled Successfully');
        }
    }

    public function store(Request $request)
    {
        if (!has_permission('version_menu', 'create')) {
            abort(403);
        }
        if (!has_module_access('version_menu')) {
            abort(403);
        }

        $validated =  $request->validate([
            'version_name' => 'required',
            'status' => 'required',
            'version_num' => 'required|integer',
            'alignment' => 'required|integer',
            'audiotype' => 'required',
            'metadescription' => 'nullable|string|max:160',
            'metakeywords' => 'nullable|string|max:255',
        ], [

            'audiotype.required' => 'Audio Type is Required',
            'alignment.required' => 'Alignment is Required',
            'version_name.required' => 'Version Name is Required',
            'version_num.required' => 'Version Number is Required',
            'version_num.integer' => 'Version Number must be a Number',
            'status.required' => 'Status is Required',
        ]);

        // ✅ Save to database
        
        $version = new Version();
        $version->version_name = $request->version_name;
        $version->status = $request->status;
        $version->version_num = $request->version_num;
        $version->alignment = $request->alignment;
        $version->metadescription = $request->metadescription;
        $version->metakeywords = $request->metakeywords;
        $version->lang_id = explode('|', $request->languageid)[0];
        $version->lang = explode('|', $request->languageid)[1];
        $version->audiotype = $request->audiotype;
        $version->createdby = Auth::guard('admin')->user()->name;
        $version->updatedby = Auth::guard('admin')->user()->name;
        $version->createdid = Auth::guard('admin')->user()->id;
        $version->updatedid = Auth::guard('admin')->user()->id;
        $version->save();

        if ($version->save()) {
            $tableName = "record".$version->id;
            $versions = Version::where('id',$version->id)->first();
            $version->version_name = $versions->version_name;

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
        }
        

        $version->save();
        LogActivity::addToLog();

        return back()->with('message','Version Added Successfully');

    }

    public function delete(Request $request, $id)
    {
        if (!has_permission('version_menu', 'delete')) {
            abort(403);
        }
        if (!has_module_access('version_menu')) {
            abort(403);
        }

        LogActivity::addToLog();

        $Q1 = Version::find($id);
        $Q1->deleted_at = '1';
        $Q1->save();
        return back()->with('message','Delete Record Successfully');

    }

    public function EditCategory($id)
    {
        if (!has_permission('version_menu', 'update')) {
            abort(403);
        }
        if (!has_module_access('version_menu')) {
            abort(403);
        }

        $version = Version::findOrFail($id);
        
        $lang = Lang::all();
        $version_num = Version::with('version_num')->max('version_num') ;
        $version_num += 1;

        return view('admin.version.version.edit_version_list', compact('version','lang','version_num'));

    }

    public function EditCatList(Request $request, $id)
    {
        if (!has_permission('version_menu', 'update')) {
            abort(403);
        }
        if (!has_module_access('version_menu')) {
            abort(403);
        }

        $validated            =  $request->validate([
            'version_name'    => 'required',
            'status'          => 'required',
            'version_num'     => 'required|integer',
            'alignment'       => 'required|integer',
            'audiotype'       => 'required',
            'metadescription' => 'nullable|string|max:160',
            'metakeywords'    => 'nullable|string|max:255',
        ], [

            'audiotype.required' => 'Audio Type is Required',
            'alignment.required' => 'Alignment is Required',
            'version_name.required' => 'Version Name is Required',
            'version_num.required' => 'Version Number is Required',
            'version_num.integer' => 'Version Number must be a Number',
            'status.required' => 'Status is Required',
        ]);

        // Find existing record
        $version = Version::findOrFail($id);

        $version->version_name = $request->version_name;
        $version->status = $request->status;
        $version->version_num = $request->version_num;
        $version->alignment = $request->alignment;
        $version->metadescription = $request->metadescription;
        $version->metakeywords = $request->metakeywords;
        $version->lang_id = explode('|', $request->languageid)[0];
        $version->lang = explode('|', $request->languageid)[1];
        $version->audiotype = $request->audiotype;
        $version->createdby = Auth::guard('admin')->user()->name;
        $version->updatedby = Auth::guard('admin')->user()->name;
        $version->createdid = Auth::guard('admin')->user()->id;
        $version->updatedid = Auth::guard('admin')->user()->id;
        $version->save();

        if ($version->save()) {
            $tableName = "record".$version->id;
            $versions = Version::where('id',$version->id)->first();
            $version->version_name = $versions->version_name;

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
        }
        

        $version->save();
        LogActivity::addToLog();

        return redirect()->to(url('admin/version_list') . '#' . $version->id)
                 ->with('message', 'Version Edited successfully!');

    }

}
