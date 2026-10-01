<?php

namespace App\Http\Controllers;
use App\Models\AppList;
use App\Models\MappedAppCategory;
use App\Models\Prayer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use App\Helpers\LogActivity;
class MappedApp extends Controller
{
    public function insert(Request $request, $id)
    {
        $app_id = $id; 
        $res = MappedAppCategory::where('app_id',$app_id)->delete();
        
        $count = $request->input('countries');

        if(!empty($count))
        {
            $countlist = $count ?? '';
            if(is_array($countlist) || is_object($countlist)) 
            {
                foreach($countlist as $count)
                {   
                    $font = Prayer::find($count);
                    LogActivity::addToLog();
                    MappedAppCategory::create([
                        'app_id' => $id,
                        'category_id' => $count,
                        'language_code' => $font->language_code,
                    ]);
                }
                return back()->with('message','Font Mapped Successfully');
            }
        }
        else
        {        
            return back()->with('message','Font Mapped Successfully');
        }
    }
}
