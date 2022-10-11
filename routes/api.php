<?php

use App\Http\Controllers\EmployeController;
use App\Http\Controllers\API\PassportAuthController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/employe', 'EmployeController@store');
Route::get('/employe', 'EmployeController@index');
Route::get('/attendance', 'AttendanceController@index');
Route::post('/attendance', 'AttendanceController@store');