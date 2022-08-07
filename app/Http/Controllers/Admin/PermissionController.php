<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

use Auth,Log,Hash,Str,Session;
use Illuminate\Contracts\Session\Session as SessionSession;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\ApiLogController as ApiLog;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

class PermissionController extends Controller
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
        // $explodeUrl = explode('/',$_SERVER['REQUEST_URI']);
        return view('Admin.permission');
    }
    public function getPermission(Request $request)
    {
        // dd($request->all(),$request->has('ip'));
        $datas = Permission::get();
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
        // dd($request->all());
        $request->validate([
            'permissionName' => 'required|unique:permissions,name',
        ]);
        if(@$request->crud == "true" ){
            Permission::create(['name'=>"view ".$request->permissionName]);
            Permission::create(['name'=>"add ".$request->permissionName]);
            Permission::create(['name'=>"update ".$request->permissionName]);
            Permission::create(['name'=>"delete ".$request->permissionName]);
        }else{
            Permission::create(['name'=>$request->permissionName]);
        }
        // Permission::create(['name'=>$request->permissionName]);
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
            $role = Permission::findOrFail($request->id);
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
            'permissionName' => 'required|unique:permissions,name,'.$request->mainId,
        ]);
        try{
            $role = Permission::findOrFail($request->mainId);
            $roleLog = $role;
            $role->name = $request->permissionName;
            $role->save();
            $data = [
                'before'=>$roleLog,
                'after'=>$role,
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
            $role = Permission::findOrFail($request->id);
            $roleLog = $role;
            $role->delete();

            Session::flash('success','Data Berhasil Dihapus');
            return $this->ApiLog->ReturnResult(200,'Data Berhasil Dihapus',$roleLog,'');

        }catch(ModelNotFoundException $e){
            return $this->ApiLog->ReturnResult(500,'Data Gagal Dihapus','',$e->getMessage());
        }
    }
}
