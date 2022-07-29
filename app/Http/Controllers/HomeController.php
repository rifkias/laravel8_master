<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth,Log,Hash,Str,Session;
use Illuminate\Contracts\Session\Session as SessionSession;
use Yajra\Datatables\Datatables;

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
        $users = Auth::user()->authentications()->get();
        $this->data['users'] = $users;
        // $user = User::findOrFail(1)->first();
        // $user->assignRole("superadmin");
        // dd($user);
        // dd(Auth::user()->getRoleNames());
        // Auth::user()->assignPermission
        // Log::debug("This is an test DEBUG log event");
        return view('home')->with($this->data);
        // return view('layouts.auth');
    }
    public function profile()
    {
        return view('users.profile');
    }
    public function profileEdit(Request $request)
    {
        // dd($request->all());
        if(($request->has('old_password') && !is_null($request->old_password)) || ($request->has('password') && !is_null($request->password))){
            $valid = request()->validate([
                'name' => 'required',
                'password' => 'required|min:8|confirmed',
                'old_password' => [
                    'required',
                    function($attribute, $value, $fail){
                        if(!Hash::check($value,Auth::user()->password)){
                            $fail('The Old Password is Incorrect');
                        }
                    },
                ],
            ]);
        }else{
            $valid = request()->validate([
                'name' => 'required',
            ]);
        }
        $user = User::findOrFail(Auth::user()->id);
        $user->name = $request->name;
        if($request->password){
            $user->password = Hash::make($request->password);
        }
        $user->save();
        Session::flash('success','Data Berhasil Disimpan');
        return redirect()->back();
    }

    public function history()
    {
        return view('users.userlog');
    }
    public function loginHistory(Request $request)
    {
        // dd($request->all(),$request->has('ip'));
        $users = User::findOrFail(Auth::user()->id)->authentications()->where('cleared_by_user',0)->get();
        // dd($users);
        return Datatables::of($users)
        ->addIndexColumn()
        ->removeColumn('id')
        ->filter(function($instance) use ($request){
            if($request->has('login_success')){
                if(!$this->isNullOrEmpty($request->login_success)){
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        if($request->login_success == "true"){
                            if($row['login_successful'] == 1){
                                return true;
                            }else{
                                return false;
                            }
                        }else{
                            // echo 'test';
                            if($row['login_successful'] == 0){
                                return true;
                            }else{
                                return false;
                            }
                        }
                    });
                }
            }
            if($request->has('login_time')){
                if(!$this->isNullOrEmpty($request->login_time)){
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        $date = explode("-",$request->login_time);
                        $start = str_replace("/","-",$date[0]);
                        $end = str_replace("/","-",$date[1]);
                        $curDate = explode("T",$row['login_at']);
                        if((strtotime($curDate[0]) >= strtotime($start)) && strtotime($curDate[0]) <= strtotime($end)){
                            return true;
                        }else{
                            return false;
                        }
                    });
                }

            }
            //   // dd($request->all(),$request->login_time);
            //   if(!$this->isNullOrEmpty($request->login_time)){
            //
            //     $result = $this->checkInDateRange($startDate,$endDate,$row['login_at']);
            //     echo $startDate;
            //     echo ' '.$endDate;
            //     echo ' '.$row['login_at'];
            //     echo ' '.$result.'res';
            //     echo "\r\n";
            //     return true;;
            // }
        })

        // dd($array);

        ->make();
        // dd($users);
    }
    public function loginHistoryDelete()
    {
        User::findOrFail(Auth::user()->id)->authentications()->where('cleared_by_user',0)->update(
            ['cleared_by_user' => 1]
        );
        Session::flash('success','Login History Has Been Clear');
        return redirect()->back();
    }
    private function isNullOrEmpty($str){
        return ($str === null || trim($str) === '');
    }
}
