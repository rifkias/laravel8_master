<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
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
Route::group(['as'=>'user.profile.','prefix'=>'/dashboard/profile'],function(){
    Route::get('/',[HomeController::class,'profile'])->name('main');
    Route::post('/edit',[HomeController::class,'profileEdit'])->name('edit');
    Route::get('/history',[HomeController::class,'history'])->name('history');
});

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
