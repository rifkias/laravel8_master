<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

use Auth,Log,Hash,Str,Session;
use Illuminate\Contracts\Session\Session as SessionSession;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\ApiLogController as ApiLog;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->ApiLog = new Apilog;
        $this->middleware('checkPermission');
    }
    public function index()
    {
        // if(Auth::user()->hasPermissionTo('view role')){
        //     dd(Auth::user());
        // }else{
        //     return "Doesn't have permission";
        // }
        // dd(\Request::route()->getName());
        $this->data['permission'] = Permission::select('name')->get();
        return view('Admin.role')->with($this->data);
    }
    public function getRole(Request $request)
    {
        // dd($request->all(),$request->has('ip'));
        $datas = Role::get();
        // dd($users);
        return Datatables::of($datas)
        ->addIndexColumn()
        ->removeColumn('id')
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

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'roleName' => 'required|unique:roles,name',
        ]);
        Role::create(['name'=>$request->roleName]);
        Session::flash('success','Data Berhasil dibuat');
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
            $role = Role::with('permissions:name')->findOrFail($request->id);
            return $this->ApiLog->ReturnResult(200,'Success',$role,'');
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
            'mainId' => 'required|numeric',
            'roleName' => 'required|unique:roles,name,'.$request->mainId,
            'permission' => 'array'
        ]);
        try{
            $role = Role::findOrFail($request->mainId);
            $roleLog = $role;
            $role->name = $request->roleName;
            $role->save();
            $role->syncPermissions($request->permission);
            $data = [
                'before'=>$roleLog,
                'after'=>$role,
                'data'=>$request->all()
            ];
            Session::flash('success','Data Berhasil diubah');
            $this->ApiLog->ReturnResult(200,'Data Berhasil diubah',$data,'');

        }catch(ModelNotFoundException $e){
            Session::flash('warning','Data Gagal diubah');
            $this->ApiLog->ReturnResult(500,'Data Gagal diubah','',$e->getMessage());
        }
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
            $role = Role::findOrFail($request->id);
            $roleLog = $role;
            $role->delete();

            Session::flash('success','Data Berhasil Dihapus');
            return $this->ApiLog->ReturnResult(200,'Data Berhasil Dihapus',$roleLog,'');

        }catch(ModelNotFoundException $e){
            return $this->ApiLog->ReturnResult(500,'Data Gagal Dihapus','',$e->getMessage());
        }
    }
}
