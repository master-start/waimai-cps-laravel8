<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('foo', function () {
    return 'Hello World';
});


Route::prefix('user')->group(function (){
    Route::any('login/wxlogin',[\App\Http\Controllers\MiniProgramController::class,'login']);
    Route::any('user/info',[\App\Http\Controllers\MiniProgramController::class,'info']);
    Route::any('index/get_meituan_url',[\App\Http\Controllers\MiniProgramController::class,'get_meituan_url']);
    Route::any('setting/index',[\App\Http\Controllers\MiniProgramController::class,'setting']);
    Route::any('user/wxQrcode',[\App\Http\Controllers\MiniProgramController::class,'wxQrcode']);
    Route::any('index/get_meituan_qrcode',[\App\Http\Controllers\MiniProgramController::class,'get_meituan_qrcode']);
    Route::any('index/banner',[\App\Http\Controllers\UserController::class,'banner']);
    Route::any('index/ad',[\App\Http\Controllers\UserController::class,'ad']);
    Route::any('test',function (){
        return 111;
    });
});
