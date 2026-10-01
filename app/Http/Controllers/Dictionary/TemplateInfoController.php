<?php

namespace App\Http\Controllers\Dictionary;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Dictionary\TemplateInfo;
use App\Models\Dictionary\DictionaryInfo;
use App\Models\Version;
use App\Helpers\LogActivity;
use DataTables;

use App\Rules\ExistsInMysql2;

class TemplateInfoController extends Controller
{
    public function show(Request $request)
    {
        if (!has_permission('template_menu', 'read')) {
            abort(403);
        }
        if (!has_module_access('template_menu')) {
            abort(403);
        }
        
        if($request->ajax()) {
            $template_infos = TemplateInfo::where('deleted_at',0);
            return DataTables::of($template_infos)
                ->addColumn('template_name', function ($item) {
                    return '<div id="'.$item->id.'">'.htmlspecialchars($item->template_name).'</div>';
                })
                ->addColumn('version_id', function ($item) {
                    return $item->version_id != null ? $item->version->version_name : "";
                })
                ->addColumn('dictionary_word_ids', function ($category) {
                    // Decode the JSON-encoded category IDs
                    $categoryIds = explode(',',$category->dictionary_word_ids);
                    $categoryNames = [];

                    // Fetch category names using relationship
                    foreach ($categoryIds as $categoryId) {
                        $categoryNames[] = (string) DictionaryInfo::find($categoryId)->word;
                    }
                    // Return category names as a string
                    return "<h6 class='fw-bold'>" .count($categoryNames). "- [".implode(', ', $categoryNames)."]</h6>";
                })
                ->addColumn('created_at', function ($item) {
                    $date                      = $item->created_at->addHours(5)->addMinutes(30);
                    return '<div class="date-info">
                                <span class="fw-semibold">'.$date->format('D d, M Y').'</span><br>
                                <span class="text-muted">'.$date->format('h:i A').'</span>
                            </div>';
                })
                ->addColumn('status', function ($item) {
                    return $item->is_active    == '0' ? 
                        '<span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Enabled</span>' : 
                        '<span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i> Disabled</span>';
                })
                ->addColumn('action', function ($items) {
                    $editUrl                   = url("admin/edit_template/".$items->id);
                    $deleteUrl                 = url("admin/delete_template/".$items->id);
                    $editDisable               = !has_permission('template_menu', 'update') == true ? "disabled":"";
                    $deleteDisable             = !has_permission('template_menu', 'delete') == true ? "disabled":"";

                    return '<div class="btn-group">
                                <form action="'.$editUrl.'" method="POST">'.csrf_field().'
                                    <button  type="submit" class="btn btn-icon btn-circle btn-sm btn-outline-primary '.$editDisable.'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit App" style="background: #7367EF !important;border-color:#7367EFcf;color:#ffffff !important;"><i class="fa fa-edit"></i></button>
                                </form>
                                <form  id="form_submit_'.$items->id.'"   action="'.$deleteUrl.'" method="POST" style="padding-left:5px;">'.csrf_field().'
                                    <input id="disable_'.$items->id.'" type="hidden" name="ad_app_type"  class="form-control" />
                                    <button  type="button" class="btn btn-icon btn-circle btn-sm btn-outline-danger '.$deleteDisable.'"  onclick="return validateform('.$items->id.')"  data-bs-toggle="tooltip" data-bs-placement="top" title="Delete App" style="background: #EE4B2B;border-color:#EE4B2B;color:#ffffff !important"><i class="fa fa-trash-can-arrow-up"></i></button>
                                </form>
                            </div>';
                })
                ->addColumn('status_update', function ($items) {
                    $statusUpdateUrl = url('admin/template_status_update');
                    $statusText = $items->is_active == '0' ? 'Enable' : 'Disable';
                    $statusValue = $items->is_active == '0' ? '0' : '1';
                    $statusDisable             = !has_permission('template_menu', 'status') == true ? "disabled":"";
                    if($statusValue == 1)
                    {
                        return '<center><form action="'.$statusUpdateUrl.'" method="POST">'.
                                csrf_field().
                                '<input type="hidden" name="template_id" value="'.$items->id.'">'.
                                ($items->is_active == '0' ? '<input type="hidden" name="status" value="0">' : '<input type="hidden" name="status" value="1">').
                                '<button type="submit" data-toggle="tooltip" data-original-title="'.$statusText.'" id="status_btn" name="status_btn" title="" class="btn_status btn btn-success btn-sm '.($items->is_active == '0' ? 'enable ' : '').''.$statusDisable.'" style="background: #ffad46!important;border-color: #ffad46!important;color: #fff!important;">
                                    <i class="fa fa-solid fa-circle"></i>
                                </button>
                            </form></center>';
                    }else{

                        return '<center><form action="'.$statusUpdateUrl.'" target="_top" method="POST">'.
                                    csrf_field().
                                    '<input type="hidden" name="template_id" value="'.$items->id.'">'.
                                    ($items->is_active == '0' ? '<input type="hidden" name="status" value="0">' : '<input type="hidden" name="status" value="1">').
                                    '<button type="submit" data-toggle="tooltip" data-original-title="'.$statusText.'" id="status_btn" name="status_btn" title="" class="btn_status btn btn-success btn-sm '.($items->is_active == '0' ? 'enable ' : '').''.$statusDisable.'" >
                                        <i class="fa fa-solid fa-circle"></i>
                                    </button>
                                </form></center>';
                    }
                })
                ->rawColumns(['dictionary_word_ids','version_id','template_name', 'created_at', 'status', 'action', 'status_update'])
                ->orderColumn('version_id', function($query, $order) {
                    $query->orderBy('version_id', $order);
                })
                ->orderColumn('dictionary_word_ids', function($query, $order) {
                    $query->orderBy('dictionary_word_ids', $order);
                })
                ->orderColumn('template_name', function($query, $order) {
                    $query->orderBy('template_name', $order);
                })
                ->orderColumn('status', function($query, $order) {
                    $query->orderBy('is_active', $order);
                })
                ->orderColumn('created_at', function($query, $order) {
                    $query->orderBy('created_at', $order);
                })
                ->filterColumn('created_at', function($query, $keyword) {
                    $query->whereDate('created_at', 'like', "%{$keyword}%");
                })
                ->filter(function ($query) use ($request) {
                    if ($request->has('search') && $keyword = $request->get('search')['value']) {
                        $query->where(function($q) use ($keyword) {
                            $q->where('template_name', 'like', "%{$keyword}%")
                            ->orWhere(function($query) use ($keyword) {
                                if (str_contains(strtolower($keyword), 'enabled')) {
                                    $query->where('is_active', 0);
                                } elseif (str_contains(strtolower($keyword), 'disabled')) {
                                    $query->where('is_active', 1);
                                }
                            })
                            ->orWhereDate('created_at', 'like', "%{$keyword}%")
                            ->orWhereIn('version_id', function($subQuery) use ($keyword) {
                                $subQuery->select('id')
                                    ->from(\DB::connection('mysql2')->table('versions'))
                                    ->where('version_name', 'like', "%{$keyword}%");
                            })
                            ->orWhere(function($query) use ($keyword) {
                                
                                // OR if you're storing IDs as comma-separated values
                                $dictionaryWordIds = DictionaryInfo::where('word', 'like', "%{$keyword}%")
                                    ->pluck('id')
                                    ->toArray();
                                
                                if (!empty($dictionaryWordIds)) {
                                    foreach ($dictionaryWordIds as $wordId) {
                                        $query->orWhere('dictionary_word_ids', 'like', "%{$wordId}%");
                                    }
                                }
                            });
                        });
                    }
                })
                ->make(true);
        }

        return view('admin.dictionary.template.template_list');

    }

    function Add_list()
    {
        if (!has_permission('template_menu', 'create')) {
            abort(403);
        }
        if (!has_module_access('template_menu')) {
            abort(403);
        }
        LogActivity::addToLog();
    
        $wordsVersionId = DictionaryInfo::groupBy('version_id')
            ->where('deleted_at', 0)
            ->pluck('version_id')->toArray();
            
        $versions = Version::whereIn('id', $wordsVersionId)->where('deleted_at', 0)->get();

        return view('admin.dictionary.template.add_template', compact('versions'));

    }

    public function active(Request $request)
    {
        if (!has_permission('template_menu', 'status')) {
            abort(403);
        }

        if (!has_module_access('template_menu')) {
            abort(403);
        }

        LogActivity::addToLog();

        $cat_id = $request->template_id;
        $status = $request->status;
        if($status == 0)
        {
            $app_active = TemplateInfo::find($cat_id);
            $app_active->is_active ='1';
            $app_active->save();
            return back()->with('message','Word Disabled Successfully');
        }
        if($status == 1)
        {
            $app_active = TemplateInfo::find($cat_id);
            $app_active->is_active ='0';
            $app_active->save();
            return back()->with('message','Word Enabled Successfully');
        }
    }

    public function store(Request $request)
    {
        if (!has_permission('template_menu', 'create')) {
            abort(403);
        }
        if (!has_module_access('template_menu')) {
            abort(403);
        }
        
        // Validate the request
        $validated = $request->validate([
            'version_id' => ['required', new ExistsInMysql2('versions', 'id')],
            'template_name' => 'nullable|string|max:25',
        ]);

        // Start database transaction
        \DB::beginTransaction();

        try {
        
            $template                      = new TemplateInfo();
            $template->template_name	   = $request->template_name;
            $template->version_id          = $request->version_id;
            $version                       = Version::where('id',$request->version_id)->first();
            $template->template_bible_name = $version->version_name;
            $wordsIds = DictionaryInfo::where('version_id',$request->version_id)->pluck('id')->toArray();
            $template->dictionary_word_ids = implode(',',$wordsIds);
            $template->save();

            // Commit transaction
            \DB::commit();

            return back()->with('message', 'TemplateInfos added successfully!');
        } catch (\Exception $e) {
            // Rollback transaction on error
            \DB::rollBack();
            return back()->withInput()->with('error', 'Error saving templates: ' . $e->getMessage());
        }
    }

    public function delete(Request $request, $id)
    {
        if (!has_permission('template_menu', 'delete')) {
            abort(403);
        }
        if (!has_module_access('template_menu')) {
            abort(403);
        }

        LogActivity::addToLog();

        $Q1 = TemplateInfo::find($id);
        $Q1->deleted_at = '1';
        $Q1->save();
        return back()->with('message','Delete Record Successfully');

    }

    public function EditCategory($id)
    {
        if (!has_permission('template_menu', 'update')) {
            abort(403);
        }
        if (!has_module_access('template_menu')) {
            abort(403);
        }

        $template = TemplateInfo::findOrFail($id);
       
        
        $wordsVersionId = DictionaryInfo::groupBy('version_id')
            ->where('deleted_at', 0)
            ->pluck('version_id')->toArray();
            
        $versions = Version::whereIn('id', $wordsVersionId)->where('deleted_at', 0)->get();

        return view('admin.dictionary.template.edit_template_list', compact('template','versions'));

    }

    public function EditCatList(Request $request, $id)
    {
        if (!has_permission('template_menu', 'update')) {
            abort(403);
        }
        if (!has_module_access('template_menu')) {
            abort(403);
        }

        // Validate the request
        $validated = $request->validate([
            'version_id' => ['required', new ExistsInMysql2('versions', 'id')],
            'template_name' => 'nullable|string|max:25',
        ]);

        // Start database transaction
        \DB::connection('mysql2')->beginTransaction();

        try {
            // Process each template
            $template                      = TemplateInfo::findOrFail($id);
            $template->template_name	   = $request->template_name;
            $template->version_id          = $request->version_id;
            $version                       = Version::where('id',$request->version_id)->first();
            $template->template_bible_name = $version->version_name;
            $wordsIds                      = DictionaryInfo::where('version_id',$request->version_id)->pluck('id')->toArray();
            $template->dictionary_word_ids = implode(',',$wordsIds);
            $template->save();

            // Commit transaction
            \DB::connection('mysql2')->commit();

            return redirect()->to(url('admin/template_list') . '#' . $template->id)
                    ->with('message', 'TemplateInfo Edited successfully!');
        } catch (\Exception $e) {
            // Rollback transaction on error
            \DB::connection('mysql2')->rollBack();
            return back()->withInput()->with('error', 'Error saving templates: ' . $e->getMessage());
        }

    }

}
