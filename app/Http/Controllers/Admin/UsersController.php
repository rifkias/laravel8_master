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
        $datas = $user->with('roles')->get();
        // $datas = User::all()->except(Auth::id());
        return Datatables::of($datas)
        /*
        ->filter(function($query) use($request){
            if($request->has('filter_role')){
                $query->role($request->filter_role);
            }
        })
        */
        ->addIndexColumn()
        ->removeColumn('id')
        ->addColumn('role',function($data){
            // return @$data->roles[0]->name;
            if(isset($data->roles[0])){
                return @$data->roles[0]->name;
            }else{
                return '-';
            }
            /*
            $role = $data->getRoleNames();
            if(isset($role[0])){
                return $role[0];
            }else{
                return "-";
            }
            */
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
                'company'=>'required',
                'phone'=>'required|numeric|nullable',
                'mobile'=>'required|numeric|unique:users,mobile|nullable',
                'gender'=>'required',
                'picture'=>'nullable|mimes:jpg,png,jpeg',
            ]);
            $company = $request->company;
        }else{
            $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|unique:users,email|email',
                'password' => 'required',
                'role' => 'required',
                'phone'=>'numeric|nullable',
                'mobile'=>'numeric|unique:users,mobile|nullable',
                'gender'=>'required',
                'picture'=>'nullable|mimes:jpg,png,jpeg',
            ]);
            $company = Auth::user()->company_id;
        }
        if($request->picture){
            $file = $this->ApiLog->MoveFile($request->picture);
        }else{
            $file = null;
        }
        $masuk = [
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'company_id'=>$company,
            'phone_number'=>$request->phone,
            'mobile'=>$request->mobile,
            'gender'=>$request->gender,
            'picture'=>$file,
            'status'=>'active'
        ];
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
            'company'=>'required',
            'phone'=>'numeric|nullable',
            'mobile'=>'numeric|unique:users,mobile,'.$request->mainId.'|nullable',
            'gender'=>'required',
            'status'=>'required',
            'picture' => 'nullable|mimes:jpg,png,jpeg'
        ]);
        try {
             $data = User::with('roles')->findOrFail($request->mainId);
            $dataLog = $data;
            $data->name = $request->name;
            $data->email = $request->email;
            $data->company_id = $request->company;
            $data->mobile = $request->mobile;
            $data->phone_number = $request->phone;
            $data->gender = $request->gender;
            $data->status = $request->status;
            if($request->password){
                $data->password = Hash::make($request->password);
            }
            if($request->picture){
                $data->picture = $this->ApiLog->MoveFile($request->picture);
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
            throw $th;
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
