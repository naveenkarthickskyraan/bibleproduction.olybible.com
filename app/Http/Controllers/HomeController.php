<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use App\Models\Module;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'name' =>'required|min:8|string|max:25',
            'email'=>'required|email|string|max:255',
            "password" => 'required|confirmed|min:8'
        ],
        [
            'password.same'=>'password are not the same password must match same value',
            'password.min'=>'confirm-password length must be greater than 8 characters',
        ]);
        $user = Auth::user();
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->image = $request['file'];
        $user->password = Hash::make($request['password']);
        if($request->hasFile('file'))
        { 
            $destination_path = 'public/files/user';
            $image = $request['file'];
            $user->image= $request['file'];
            $image_name = $image->getClientOriginalName();
            $extension = pathinfo($image_name, PATHINFO_EXTENSION);
            $encrpt = round(microtime(true)*1000);
            $new_name = ($encrpt).'.'.$extension;
            $path = $request->file('file')->storeAs($destination_path , $new_name , '');
            $new_name = 'files/user/'.$new_name;
        }
        $uploaded_file = $new_name ?? ''; 
        $user->image = $uploaded_file;
        $user->save();
        return back()->with('message','Profile Updated Successfully');

    }

    public function myTestAddToLog()
    {
        LogActivity::addToLog('My Testing Add To Log.');
        dd('log insert successfully.');
    }

    public function logActivity()
    {
        $role = Auth::guard('admin')->user()->role;
        $AccessPrivilege = Auth::guard('admin')->user()->accountAccessPrivilege;
        $AccessModule = Auth::guard('admin')->user()->accountAccessModule;
        $explode = explode('|',$AccessModule);
        $explode_1 = explode('|',$AccessPrivilege);
        $module = Module::Select(['module_name'])->whereIn('module_name',$explode)->get();
        $permission=[];
        foreach($module as $row)
        {
            $permission[] = $row->module_name;
        }
        $permis = $permission;
        $array = in_array('Activity', $permis);
        $array_1= in_array('view',$explode_1);
        if(($role == "SuperAdmin") || ($array == true &&  $array_1 == true))
        {
            $logs = LogActivity::logActivityLists();
            return view('logActivity', compact('logs'));
        }
        else
        {
            return redirect()->route('admin/dashboard')->with("error","Access Denied");
        }
    }
}
