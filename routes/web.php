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
Route::get('sc', function () {
    return "sc";
});
Route::get('/rr', [\App\Http\Controllers\v1\Weixin\TestController::class, 'rr']);
Route::get('/dd', [\App\Http\Controllers\v1\Weixin\TestController::class, 'dd']);
Route::get('/ddd', [\App\Http\Controllers\v1\Weixin\TestController::class, 'ddd']);
Route::get('/a', [\App\Http\Controllers\v1\Weixin\TestController::class, 'a']);


