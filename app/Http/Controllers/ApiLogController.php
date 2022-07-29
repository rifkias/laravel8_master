<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Log,Auth;
class ApiLogController extends Controller
{
    public function ReturnResult($status = null,$message = null,$data = null,$error = null){

        $datas = json_encode([
            'url' => url()->full(),
            'auth' => Auth::user() ?: NULL,
            'status'=>$status,
            'message'=>$message,
            'data'=>$data,
            'error'=>$error
        ]);
        if($status == 200){
            Log::info($datas);
        }else{
            Log::error($datas);
        }
        return response()->json([
            'status'=>$status,
            'message'=>$message,
            'data'=>$data,
            'error'=>$error
        ]);
    }
    public function checkPermission($name = null)
    {
        # code...
    }
}
