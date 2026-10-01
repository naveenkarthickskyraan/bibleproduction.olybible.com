<?php

namespace App\Http\Controllers\Dictionary;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Dictionary\AppInfo;
use App\Models\Dictionary\TemplateInfo;
use App\Helpers\LogActivity;
use Storage;
use DataTables;

class AppInfoController extends Controller
{
    public function show(Request $request)
    {
        if (!has_permission('apps_menu', 'read')) {
            abort(403);
        }
        if (!has_module_access('apps_menu')) {
            abort(403);
        }

        $app_infos = AppInfo::where('app_infos.deleted_at',0);

        if($request->ajax()) {
            return DataTables::of($app_infos)
                ->addColumn('app_name', function ($item) {
                    return '<div id="'.$item->id.'">'.htmlspecialchars($item->app_name).'</div>';
                })
                ->addColumn('app_type', function ($item) {
                    return $item->app_type == 'android' ? 
                        '<span class="badge badge-sm bg-success">Android</span>' : 
                        '<span class="badge bg-primary">iOS</span>';
                })
                ->addColumn('package_name', function ($item) {
                    if($item->app_type == 'android') {
                        return '<div class="package-info">
                                    <span class="fw-bold">Package Name: </span>
                                    <span class="text-muted">'.htmlspecialchars($item->package_name).'</span>
                                </div>';
                    } else {
                        return '<div class="ios-info">
                                    <div><span class="fw-bold">Apple ID: </span>'.htmlspecialchars($item->apple_id).'</div>
                                    <div><span class="fw-bold">Bundle ID: </span>'.htmlspecialchars($item->bundle_id).'</div>
                                </div>';
                    }
                })
                ->addColumn('app_image', function ($item) {
                    $defaultImage = asset('images/no-camera.png');
                    
                    if(empty($item->app_image)) {
                        return '<div class="text-center">
                                    <img src="'.$defaultImage.'" class="app-thumbnail" alt="No Image">
                                </div>';
                    }
                    
                    $imageUrl = asset("storage/".$item->app_image);
                    $isExternal = isset($item->image_type) && $item->image_type == 1;
                    
                    return '<div class="text-center">
                                <a href="'.$imageUrl.'" target="_blank" data-bs-toggle="tooltip" title="View image in new tab">
                                    <img src="'.$imageUrl.'" class="app-thumbnail" alt="App Image">
                                </a>
                            </div>';
                })
                ->addColumn('store_url', function ($item) {
                    if(!empty($item->playstore_url) && $item->app_type == "android") {
                        return '<a href="'.$item->playstore_url.'" target="_blank" class="store-link">
                                    <i class="fab fa-google-play"></i> Play Store
                                </a>';
                    } else if(!empty($item->appstore_url) && $item->appstore_url != null) {
                        return '<a href="'.$item->appstore_url.'" target="_blank" class="store-link">
                                    <i class="fab fa-apple"></i> App Store
                                </a>';
                    }
                    return '<span class="text-muted">N/A</span>';
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
                    $editUrl                 = url("admin/edit_apps/".$items->id);
                    $deleteUrl               = url("admin/delete_apps/".$items->id);

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
                    $statusUpdateUrl = url('admin/apps_status_update');
                    $statusText = $items->is_active == '0' ? 'Enable' : 'Disable';
                    $statusValue = $items->is_active == '0' ? '0' : '1';
                    if($statusValue == 1)
                    {
                        return '<center><form action="'.$statusUpdateUrl.'" method="POST">'.
                                csrf_field().
                                '<input type="hidden" name="apps_id" value="'.$items->id.'">'.
                                ($items->is_active == '0' ? '<input type="hidden" name="status" value="0">' : '<input type="hidden" name="status" value="1">').
                                '<button type="submit" data-toggle="tooltip" data-original-title="'.$statusText.'" id="status_btn" name="status_btn" title="" class="btn_status btn btn-success btn-sm '.($items->is_active == '0' ? 'enable' : '').'" style="background: #ffad46!important;border-color: #ffad46!important;color: #fff!important;">
                                    <i class="fa fa-solid fa-ban"></i>
                                </button>
                            </form></center>';
                    }else{

                        return '<center><form action="'.$statusUpdateUrl.'" target="_top" method="POST">'.
                                    csrf_field().
                                    '<input type="hidden" name="apps_id" value="'.$items->id.'">'.
                                    ($items->is_active == '0' ? '<input type="hidden" name="status" value="0">' : '<input type="hidden" name="status" value="1">').
                                    '<button type="submit" data-toggle="tooltip" data-original-title="'.$statusText.'" id="status_btn" name="status_btn" title="" class="btn_status btn btn-success btn-sm '.($items->is_active == '0' ? 'enable' : '').'" >
                                        <i class="fa fa-solid fa-circle"></i>
                                    </button>
                                </form></center>';
                    }
                })
                ->rawColumns(['app_name', 'app_type', 'package_name', 'app_image', 'store_url', 
                            'created_at', 'status', 'action', 'status_update'])
                 ->filterColumn('app_name', function($query, $keyword) {
                        $keyword = trim($keyword);
                        $query->where(function($q) use ($keyword) {
                            $q->where('app_name', 'like', "%{$keyword}%")
                                ->orWhere('app_description', 'like', "%{$keyword}%")
                                ->orWhere('appstore_url', 'like', "%{$keyword}%")
                                ->orWhere('playstore_url', 'like', "%{$keyword}%")
                                ->orWhere('package_name', 'like', "%{$keyword}%")
                                ->orWhere('apple_id', 'like', "%{$keyword}%")
                                ->orWhere('bundle_id', 'like', "%{$keyword}%");
                        });
                    })
                    
                    ->filterColumn('created_at', function($query, $keyword) {
                        $keyword = trim($keyword);
                        $query->whereDate('created_at', 'like', "%{$keyword}%");
                    })
                
                    ->make(true);
        }

        return view('admin.dictionary.apps.apps_list');

    }

    function Add_list()
    {
        if (!has_permission('apps_menu', 'create')) {
            abort(403);
        }
        if (!has_module_access('apps_menu')) {
            abort(403);
        }
        LogActivity::addToLog();

        $tempInfo = TemplateInfo::where('deleted_at',0)->get();

        return view('admin.dictionary.apps.add_apps', compact('tempInfo'));

    }

    public function active(Request $request)
    {
        if (!has_permission('apps_menu', 'status')) {
            abort(403);
        }

        if (!has_module_access('apps_menu')) {
            abort(403);
        }

        LogActivity::addToLog();

        $cat_id = $request->apps_id;
        $status = $request->status;
        if($status == 0)
        {
            $app_active = AppInfo::find($cat_id);
            $app_active->is_active ='1';
            $app_active->save();
            return back()->with('message','AppInfo Disabled Successfully');
        }
        if($status == 1)
        {
            $app_active = AppInfo::find($cat_id);
            $app_active->is_active ='0';
            $app_active->save();
            return back()->with('message','AppInfo Enabled Successfully');
        }
    }

    public function store(Request $request)
    {
        if (!has_permission('apps_menu', 'create')) {
            abort(403);
        }
        if (!has_module_access('apps_menu')) {
            abort(403);
        }

        $validated = $request->validate([
            'app_name'         => 'required|string|max:255',
            'app_description'  => 'required|string',
            'app_type'         => 'required|in:ios,android',
            'thumb_upload_type'=> 'required|in:1,2',
            'thumb_file'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'thumb_url_image'  => 'nullable|url',
            'temp_id'          => 'required|exists:template_infos,id',
            'apple_id'         => 'nullable|required_if:app_type,ios',
            'bundle_id'        => 'nullable|required_if:app_type,ios',
            'package_name'     => 'nullable|required_if:app_type,android',
        ]);

        // ✅ Handle image upload type
        $imagePath = null;
        if ($validated['thumb_upload_type'] == 1) {
            // File upload
            if ($request->hasFile('thumb_file')) {
                $image = $request->file('thumb_file');
                $imagePath = $image->store('app_thumbnails', 'public');  // public/storage/app_thumbnails
            }
        } elseif ($validated['thumb_upload_type'] == 2) {
            // URL Type
            $imagePath = $validated['thumb_url_image'];
        }

        // ✅ Save to database
        $apps = new AppInfo();
        $apps->app_name        = $validated['app_name'] ?? "";
        $apps->app_description = $validated['app_description'] ?? "";
        $apps->app_type        = $validated['app_type'] ?? "";
        $apps->temp_id         = $validated['temp_id'] ?? "";

        // Platform specific fields
        if ($validated['app_type'] == 'ios') {
            $apps->apple_id  = $validated['apple_id'] ?? "";
            $apps->bundle_id = $validated['bundle_id'] ?? "";
            $apps->appstore_url = "https://itunes.apple.com/app/".$request->apple_id;

        } else if ($validated['app_type'] == 'android') {
            $apps->package_name = $validated['package_name'] ?? "";
            $apps->playstore_url = "https://play.google.com/store/apps/details?id=".$request->package_name;

        }

        $apps->image_type  = $validated['thumb_upload_type'] ?? "";
        $apps->app_image   = $imagePath ?? "";

        $apps->save();

        return back()->with('message','AppInfo Added Successfully');

    }

    public function delete(Request $request, $id)
    {
        if (!has_permission('apps_menu', 'delete')) {
            abort(403);
        }
        if (!has_module_access('apps_menu')) {
            abort(403);
        }

        LogActivity::addToLog();

        $Q1 = AppInfo::find($id);
        $Q1->deleted_at = '1';
        $Q1->save();
        return back()->with('message','Delete Record Successfully');

    }

    public function EditCategory($id)
    {
        if (!has_permission('apps_menu', 'update')) {
            abort(403);
        }
        if (!has_module_access('apps_menu')) {
            abort(403);
        }

        $edit = AppInfo::find($id);
        $tempInfo = TemplateInfo::where('deleted_at',0)->get();

        return view('admin.dictionary.apps.edit_apps_list', compact('edit','tempInfo'));

    }

    public function EditCatList(Request $request, $id)
    {
        if (!has_permission('apps_menu', 'update')) {
            abort(403);
        }
        if (!has_module_access('apps_menu')) {
            abort(403);
        }

         $validated = $request->validate([
            'app_name'         => 'required|string|max:255',
            'app_description'  => 'required|string',
            'app_type'         => 'required|in:ios,android',
            'thumb_upload_type'=> 'required|in:1,2',
            'thumb_file'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'thumb_url_image'  => 'nullable|url',
            'temp_id'          => 'required|exists:template_infos,id',
            'apple_id'         => 'nullable|required_if:app_type,ios',
            'bundle_id'        => 'nullable|required_if:app_type,ios',
            'package_name'     => 'nullable|required_if:app_type,android',
        ]);

        // Find existing record
        $apps = AppInfo::findOrFail($id);

        // ✅ Handle image upload type
        $imagePath = $apps->app_image; // keep existing image if not changed

        if ($validated['thumb_upload_type'] == 1) {
            if ($request->hasFile('thumb_file')) {
                // Delete old file if exists
                if ($apps->image_type == 1 && $apps->app_image && Storage::disk('public')->exists($apps->app_image)) {
                    Storage::disk('public')->delete($apps->app_image);
                }

                $image = $request->file('thumb_file');
                $imagePath = $image->store('app_thumbnails', 'public');
            }
        } elseif ($validated['thumb_upload_type'] == 2) {
            $imagePath = $validated['thumb_url_image'];
        }

        // ✅ Update database record
        $apps->app_name        = $validated['app_name'] ?? "";
        $apps->app_description = $validated['app_description'] ?? "";
        $apps->app_type        = $validated['app_type'] ?? "";
        $apps->temp_id         = $validated['temp_id'] ?? "";

        // Platform specific fields
        if ($validated['app_type'] == 'ios') {
            $apps->apple_id       = $validated['apple_id'] ?? "";
            $apps->bundle_id      = $validated['bundle_id'] ?? "";
            $apps->appstore_url   = "https://itunes.apple.com/app/" . $request->apple_id;

            // Clear android-specific fields if switching from android
            $apps->package_name   = null;
            $apps->playstore_url  = null;

        } elseif ($validated['app_type'] == 'android') {
            $apps->package_name   = $validated['package_name'] ?? "";
            $apps->playstore_url  = "https://play.google.com/store/apps/details?id=" . $request->package_name;

            // Clear iOS-specific fields if switching from iOS
            $apps->apple_id       = null;
            $apps->bundle_id      = null;
            $apps->appstore_url   = null;
        }

        $apps->image_type  = $validated['thumb_upload_type'] ?? "";
        $apps->app_image   = $imagePath ?? "";

        $apps->save();

        return redirect()->to(url('admin/apps_list') . '#' . $apps->id)
                 ->with('message', 'AppInfo Edited Successfully!');

    }

}
