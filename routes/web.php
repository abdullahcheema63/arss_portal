<?php

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
    return redirect(url('home'));
});

Auth::routes();


Route::middleware("auth")->group(function (){
    Route::get('/home', 'HomeController@index')->name('home');

    //classroom controller
    Route::get("/classrooms","ClassroomController@index")->name("classrooms.index");
    Route::post("/classrooms","ClassroomController@store")->name("classrooms.store");
    Route::put("/classrooms/{id}","ClassroomController@update")->name("classrooms.update");
    Route::delete("/classrooms/{id}","ClassroomController@destroy")->name("classrooms.destroy");



    //students controller
    Route::get("/students","StudentController@index")->name("students.index");
    Route::post("/students","StudentController@store")->name("students.store");
    Route::put("/students/{id}","StudentController@update")->name("students.update");
    Route::delete("/students/{id}","StudentController@destroy")->name("students.destroy");
    Route::post("/students/import","StudentController@import")->name('students.import');


    Route::get("/pending-sms",function (){
       $smss=\App\SMS::where("status","pending")->get();
       $value="Pending";
       return view("sms.index",compact('smss','value'));
    });
    Route::get("sms",function (){
       $smss=\App\SMS::all();
       $value="All";
       return view("sms.index",compact('smss','value'));
    });



    //attendance controller
    Route::get("/attendance","AttendanceController@index")->name("attendance.index");
    Route::get('classrooms/mark-today-attendance/{classroom_id}','AttendanceController@markTodayAttendance')->name('attendance.mark-today-attendance-by-class');
    Route::get('classrooms/view-today-attendance/{classroom_id?}','AttendanceController@viewTodayAttendance')->name('attendance.mark-today-attendance-by-class');
    Route::post('attendance','AttendanceController@store')->name('attendance.store');
    Route::put('attendance','AttendanceController@update')->name('attendance.update');
    Route::post('attendance/send-sms/{classroom_id?}','AttendanceController@sendSMS')->name('attendance.send-sms');
});
