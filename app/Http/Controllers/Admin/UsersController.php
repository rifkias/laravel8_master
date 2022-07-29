<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin\Company;
use Spatie\Permission\Models\Role;

use Auth,Log,Hash,Str,Session;
use Illuminate\Contracts\Session\Session as SessionSession;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\ApiLogController as ApiLog;
class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct(){
        $this->ApiLog = new Apilog;
        $this->middleware('checkPermission');
    }
    public function index()
    {
        $this->data['role'] = Role::select('name')->get();
        $this->data['company'] = Company::get();
        return view('Admin.users')->with($this->data);
    }
    public function getUsers(Request $request)
    {
        // dd($request->all(),$request->has('ip'));
        $user = new User;
        $user = $user->where('id','!=',Auth::user()->id);
        if(Auth::user()->company->company_shortname != 'SAS'){
            $user = $user->where('company_id',Auth::user()->company_id);
        }
        $datas = $user->get();
        // $datas = User::all()->except(Auth::id());
        // dd($datas);
        return Datatables::of($datas)
        ->addIndexColumn()
        ->removeColumn('id')
        ->addColumn('role',function($data){
            $role = $data->getRoleNames();
            if(isset($role[0])){
                return $role[0];
            }else{
                return "-";
            }
            // return @$data->getRoleNames()[0]?: "-";
        })
        ->addColumn('company',function($data){
            if(isset($data->company)){
                return $data->company->company_shortname;
            }else{
                return "-";
            }
            // return @$data->getRoleNames()[0]?: "-";
        })
        ->addColumn('action',function($data){
            $button = "
            <button type='button' class='btn btn-warning' onclick="."Edit(".$data->id.")".">
                <i class='material-icons'>edit</i>
            </button>";
            $button .= "
            <button type='button' class='btn btn-danger' onclick="."Delete(".$data->id.")".">
                <i class='material-icons'>delete</i>
            </button>";
            return $button;
        })
        ->make();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->company->company_shortname == 'SAS'){
            $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|unique:users,email|email',
                'password' => 'required',
                'role' => 'required',
                'company'=>'required'
            ]);
            $company = $request->company;
        }else{
            $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|unique:users,email|email',
                'password' => 'required',
                'role' => 'required',
            ]);
            $company = Auth::user()->company_id;
        }
        $masuk = [
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'company_id'=>$company
        ];
        // dd($masuk);
        $user = User::create($masuk);
        $user->assignRole($request->role);
        Session::flash('success','Data Berhasil Ditambahkan');
        $this->ApiLog->ReturnResult(200,'Data Berhasil ditambahkan',$masuk,'');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        try{
            $data = User::with('roles')->findOrFail($request->id);
            return $this->ApiLog->ReturnResult(200,'Success',$data,'');

        }catch(ModelNotFoundException $e){
            return $this->ApiLog->ReturnResult(500,'Failed','',$e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|unique:users,email,'.$request->mainId.'|email',
            'role' => 'required',
            'company'=>'required'
        ]);
        try {
             $data = User::with('roles')->findOrFail($request->mainId);
            $dataLog = $data;
            $data->name = $request->name;
            $data->email = $request->email;
            $data->company_id = $request->company;
            if($request->password){
                $data->password = Hash::make($request->password);
            }
            $data->save();
            $data->roles()->detach();
            $data->assignRole($request->role);
            $data = [
                'before'=>$dataLog,
                'after'=>$data,
                'data'=>$request->all()
            ];
            Session::flash('success','Data Berhasil diubah');
        } catch (\Throwable $th) {
            //throw $th;
        }

            $this->ApiLog->ReturnResult(200,'Data Berhasil diubah',$data,'');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try{
            $data = User::findOrFail($request->id);
            $dataLog = $data;
            $data->delete();

            Session::flash('Success','Data Berhasil Dihapus');
            return $this->ApiLog->ReturnResult(200,'Data Berhasil Dihapus',$dataLog,'');

        }catch(ModelNotFoundException $e){
            return $this->ApiLog->ReturnResult(500,'Data Gagal Dihapus','',$e->getMessage());
        }
    }
}
