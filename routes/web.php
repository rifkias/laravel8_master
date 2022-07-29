<?php

use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\CompanyController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();
Route::group(['prefix'=>'dashboard','middleware'=>['auth']],function(){
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::group(['as'=>'user.profile.','prefix'=>'/profile'],function(){
        Route::get('/',[HomeController::class,'profile'])->name('main');
        Route::post('/edit',[HomeController::class,'profileEdit'])->name('edit');
        Route::get('/history',[HomeController::class,'history'])->name('history');
        Route::get('/login-history',[HomeController::class,'loginHistory'])->name('loginHistory');
        Route::post('/login-history/delete',[HomeController::class,'loginHistoryDelete'])->name('loginHistory.delete');
    });
    Route::group(['prefix'=>'administrator','middleware'=>[]],function(){
        Route::group(['prefix'=>'role','as'=>'role.'],function(){
            Route::get("/",[RoleController::class,'index'])->name('index');
            Route::get("/get-role",[RoleController::class,'getRole'])->name('getRole');
            Route::post("/add",[RoleController::class,'store'])->name('create');
            Route::post("/delete",[RoleController::class,'destroy'])->name('delete');
            Route::post("/update",[RoleController::class,'update'])->name('update');
            Route::post("/show",[RoleController::class,'edit'])->name('detail');
        });

        Route::group(['prefix'=>'permission','as'=>'permission.','middleware'=>[]],function(){
            Route::get("/",[PermissionController::class,'index'])->name('index');
            Route::get("/get-permission",[PermissionController::class,'getPermission'])->name('getPermission');
            Route::post("/add",[PermissionController::class,'store'])->name('create');
            Route::post("/delete",[PermissionController::class,'destroy'])->name('delete');
            Route::post("/update",[PermissionController::class,'update'])->name('update');
            Route::post("/show",[PermissionController::class,'edit'])->name('detail');
        });
        Route::group(['prefix'=>'users','as'=>'users.','middleware'=>['checkPermission']],function(){
            Route::get("/",[UsersController::class,'index'])->name('index');
            Route::get("/get-users",[UsersController::class,'getUsers'])->name('getUsers');
            Route::post("/add",[UsersController::class,'store'])->name('create');
            Route::post("/delete",[UsersController::class,'destroy'])->name('delete');
            Route::post("/update",[UsersController::class,'update'])->name('update');
            Route::post("/show",[UsersController::class,'edit'])->name('detail');
        });
        Route::group(['prefix'=>'company','as'=>'company.','middleware'=>['checkPermission']],function(){
            Route::get("/",[CompanyController::class,'index'])->name('index');
            Route::get("/get-company",[CompanyController::class,'getCompany'])->name('getCompany');
            Route::post("/add",[CompanyController::class,'store'])->name('create');
            Route::post("/delete",[CompanyController::class,'destroy'])->name('delete');
            Route::post("/update",[CompanyController::class,'update'])->name('update');
            Route::post("/show",[CompanyController::class,'edit'])->name('detail');
        });
    });
});
