<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use Auth;
use App\Models\Module;
Use App\Models\Admin;
use App\Models\Vidukathaigal;
use App\Models\Level;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Helpers\LogActivity;
use DataTables;
use Goutte\Client;

class VidukathaigalController extends Controller
{
    public function show(Request $request)
    {
        if (!has_permission('vidukathaigal_menu', 'read')) {
            abort(403);
        }
        if (!has_module_access('vidukathaigal_menu')) {
            abort(403);
        }

        $vidukathaigals = Vidukathaigal::with(['levels'])->where('vidukathaigals.deleted_at',0);

        if($request->ajax())
        {
            return DataTables::of($vidukathaigals)
                ->addColumn('question', function ($items) {
                    return "<div id=".$items->id.">".$items->question."</div>";
                })
                ->addColumn('created_at', function ($items) {
                    $admin_id = Admin::find($items->admin_id);
                    $colorCode = '#FF5733';
                    return '<div class="vidukathaigal-info">
                                <span style="font-weight: 600; color: #333;">'. $items->created_at->addHours(5)->addMinutes(30)->format('Y-m-d - h:i A').'</span><br>
                            </div>';
                })
                ->addColumn('status', function ($items) {
                    return $items->is_active == '0' ? '<span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span>' : '<span class="badge bg-danger rounded-fill"><i class="bi bi-exclamation-octagon me-1"></i> Deactivate</span>';
                })
                ->addColumn('action', function ($items) {
                    $editUrl = url("admin/edit_vidukathaigal/".$items->id);
                    $deleteUrl = url("admin/delete_vidukathaigal/".$items->id);

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
                    $statusUpdateUrl = url('admin/vidukathaigal_status_update');
                    $statusText = $items->is_active == '0' ? 'Enable' : 'Disable';
                    $statusValue = $items->is_active == '0' ? '0' : '1';
                    if($statusValue == 1)
                    {
                        return '<center><form action="'.$statusUpdateUrl.'" method="POST">'.
                                csrf_field().
                                '<input type="hidden" name="vidukathaigal_id" value="'.$items->id.'">'.
                                ($items->is_active == '0' ? '<input type="hidden" name="status" value="0">' : '<input type="hidden" name="status" value="1">').
                                '<button type="submit" data-toggle="tooltip" data-original-title="'.$statusText.'" id="status_btn" name="status_btn" title="" class="btn_status btn btn-success btn-sm '.($items->is_active == '0' ? 'enable' : '').'" style="background: #ffad46!important;border-color: #ffad46!important;color: #fff!important;">
                                    <i class="fa fa-solid fa-ban"></i>
                                </button>
                            </form></center>';
                    }else{

                    return '<center><form action="'.$statusUpdateUrl.'" target="_top" method="POST">'.
                                csrf_field().
                                '<input type="hidden" name="vidukathaigal_id" value="'.$items->id.'">'.
                                ($items->is_active == '0' ? '<input type="hidden" name="status" value="0">' : '<input type="hidden" name="status" value="1">').
                                '<button type="submit" data-toggle="tooltip" data-original-title="'.$statusText.'" id="status_btn" name="status_btn" title="" class="btn_status btn btn-success btn-sm '.($items->is_active == '0' ? 'enable' : '').'" >
                                    <i class="fa fa-solid fa-circle"></i>
                                </button>
                            </form></center>';
                    }
                })
                ->rawColumns(['question','created_at','app_link', 'status', 'action', 'status_update'])
                ->filterColumn('question', function($query, $keyword) {
                    $keyword = trim($keyword);
                    $query->where('question', 'like', "%{$keyword}%")
                            ->orWhere('answer', 'like', "%{$keyword}%")
                            ->orWhere('hints', 'like', "%{$keyword}%")
                            ->orWhere('created_at', 'like', "%{$keyword}%");

                })
                ->make(true);
        }

        return view('admin.vidukathaigal.vidukathaigal_list');

    }

    function Add_list()
    {
        if (!has_permission('vidukathaigal_menu', 'create')) {
            abort(403);
        }
        if (!has_module_access('vidukathaigal_menu')) {
            abort(403);
        }
        LogActivity::addToLog();

        $levels = Level::where('deleted_at',0)->get();

        return view('admin.vidukathaigal.add_vidukathaigal', compact('levels'));

    }

    public function active(Request $request)
    {
        if (!has_permission('vidukathaigal_menu', 'status')) {
            abort(403);
        }
        if (!has_module_access('vidukathaigal_menu')) {
            abort(403);
        }

        LogActivity::addToLog();

        $cat_id = $request->vidukathaigal_id;
        $status = $request->status;
        if($status == 0)
        {
            $app_active = Vidukathaigal::find($cat_id);
            $app_active->is_active ='1';
            $app_active->save();
            return back()->with('message','Vidukathaigal Disabled Successfully');
        }
        if($status == 1)
        {
            $app_active = Vidukathaigal::find($cat_id);
            $app_active->is_active ='0';
            $app_active->save();
            return back()->with('message','Vidukathaigal Enabled Successfully');
        }
    }

    public function store(Request $request)
    {
        if (!has_permission('vidukathaigal_menu', 'create')) {
            abort(403);
        }
        if (!has_module_access('vidukathaigal_menu')) {
            abort(403);
        }

        $rules=[
            'level' => 'required',
            'question' => 'required|unique:vidukathaigals,question',
            'answer' => 'required',
            'hints' => 'required',
        ];

        $request->validate($rules);
        $vidukathaigal = new Vidukathaigal;

        $vidukathaigal->level = $request->level;
        $vidukathaigal->question = $request->question;
        $vidukathaigal->answer = $request->answer;
        $vidukathaigal->hints = $request->hints;

        $vidukathaigal->save();

        return back()->with('message','Vidukathaigal Added Successfully');

    }

    public function delete(Request $request, $id)
    {
        if (!has_permission('vidukathaigal_menu', 'delete')) {
            abort(403);
        }
        if (!has_module_access('vidukathaigal_menu')) {
            abort(403);
        }

        LogActivity::addToLog();

        $Q1 = Vidukathaigal::find($id);
        $Q1->deleted_at = '1';
        $Q1->save();
        return back()->with('message','Delete Record Successfully');

    }

    public function EditCategory($id)
    {
        if (!has_permission('vidukathaigal_menu', 'update')) {
            abort(403);
        }
        if (!has_module_access('vidukathaigal_menu')) {
            abort(403);
        }

        $edit = Vidukathaigal::find($id);
        $levels = Level::where('deleted_at',0)->get();

        return view('admin.vidukathaigal.edit_vidukathaigal_list', compact('edit', 'levels'));

    }


    public function EditCatList(Request $request, $id)
    {
        if (!has_permission('vidukathaigal_menu', 'update')) {
            abort(403);
        }
        if (!has_module_access('vidukathaigal_menu')) {
            abort(403);
        }

        $rules = [
            'level' => 'required',
            'question' => 'required|unique:vidukathaigals,question,' . $id,
            'answer' => 'required',
            'hints' => 'required',
        ];

        $request->validate($rules);

        $vidukathaigal = Vidukathaigal::find($id);

        $vidukathaigal->level = $request->level;
        $vidukathaigal->question = $request->question;
        $vidukathaigal->answer = $request->answer;
        $vidukathaigal->hints = $request->hints;

        $vidukathaigal->save();

        return redirect()->to(url('admin/vidukathaigal_list') . '#' . $vidukathaigal->id)
                ->with('message', 'Vidukathaigal Edited successfully!');
    }


}
