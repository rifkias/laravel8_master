<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\Admin\Company;

use Auth,Log,Hash,Str,Session;
use Illuminate\Contracts\Session\Session as SessionSession;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\ApiLogController as ApiLog;
class CompanyController extends Controller
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
        // $this->data[] = '';
        // $this->data['role'] = Role::select('name')->get();
        return view('Admin.company');
    }
    public function getCompany(Request $request)
    {
        // dd($request->all(),$request->has('ip'));
        $datas = Company::get();
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
        $request->validate([
            'company_name' => 'required|max:255',
            'company_shortname' => 'required|unique:companys,company_shortname',
        ]);
        $masuk = [
            'company_name' => $request->company_name,
            'company_shortname' => $request->company_shortname,
            'status' => 'active',
            'created_by'=>Auth::user()->id
        ];
        // dd($masuk);
        Company::create($masuk);
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
            $data = Company::findOrFail($request->id);
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
            'company_name' => 'required|max:255',
            'company_shortname' => 'required|unique:companys,company_shortname,'.$request->mainId,
        ]);
        try{
            if($request->status){
                $status = 'active';
            }else{
                $status = 'deactive';
            }
            $data = Company::findOrFail($request->mainId);

            $dataLog = $data;

            $data->company_name = $request->company_name;
            $data->company_shortname = $request->company_shortname;
            $data->status = $status;
            $data->updated_at = now();
            $data->updated_by = Auth::user()->id;
            $data->save();

            $data = [
                'before'=>$dataLog,
                'after'=>$data,
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
            $data = Company::findOrFail($request->id);
            $data->deleted_by = Auth::user()->id;
            $data->save();
            $dataLog = $data;
            sleep(1);
            $data->delete();

            Session::flash('Success','Data Berhasil Dihapus');
            return $this->ApiLog->ReturnResult(200,'Data Berhasil Dihapus',$dataLog,'');

        }catch(ModelNotFoundException $e){
            return $this->ApiLog->ReturnResult(500,'Data Gagal Dihapus','',$e->getMessage());
        }
    }
}
