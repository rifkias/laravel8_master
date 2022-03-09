<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth,Log,Hash;
use Laravel\Ui\Presets\React;

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
        $users = Auth::user()->authentications()->get();
        // dd($users);
        return view('users.userlog');
    }
}
