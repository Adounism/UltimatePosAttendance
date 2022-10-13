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


Route::resource('/employe', 'EmployeController');
// Route::get('/employe', 'Em+ployeController@index');
Route::put('/employe', 'EmployeController@store');
Route::resource('/attendance', 'AttendanceController');
Route::post('/attendance', 'AttendanceController@store');
Route::put('/employe{id}', 'AttendanceController@update')->name('employe.update');
Route::post('/ping', 'DeviceController@ping');

// Route::middleware(['cors'])->group(function () {
//     Route::resource('/employe', 'EmployeController');
//     Route::get('/employe', 'EmployeController@index');
//     Route::put('/employe', 'EmployeController@store');
//     Route::resource('/attendance', 'AttendanceController');
//     Route::post('/attendance', 'AttendanceController@store');
//     Route::put('/employe{id}', 'AttendanceController@update')->name('employe.update');
//     Route::post('/ping', 'DeviceController@ping');
// });

