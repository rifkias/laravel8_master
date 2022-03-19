<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth,Log,Hash,Str;
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
        // dd($users);
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

        // dd($request->all());
        return view('users.profile');
    }

    public function history()
    {
        // $this->data['']
        // return view('users.userlog')->with($this->data);/
        return view('users.userlog');
    }
    public function loginHistory(Request $request)
    {
        // dd($request->all(),$request->has('ip'));
        $users = User::findOrFail(Auth::user()->id)->authentications()->get();
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
                        if((strtotime($row['login_at']) >= strtotime($start)) && strtotime($row['login_at']) <= strtotime($end)){
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
    private function isNullOrEmpty($str){
        return ($str === null || trim($str) === '');
    }
    private function checkInDateRange($startDate,$endDate,$value){
        $start = strtotime($startDate);
        $end = strtotime($endDate);
        $val = strtotime($value);

        return (($val >= $start) && ($val <= $end));
    }
}
