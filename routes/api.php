<?php

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

Route::get("/sms","SMSController@index")->name("sms.index");
Route::post("/sms","SMSController@store")->name("sms.store");
Route::put("/sms/{id}","SMSController@update")->name("sms.update");
Route::delete("/sms/{id}","SMSController@destroy")->name("sms.destroy");

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
