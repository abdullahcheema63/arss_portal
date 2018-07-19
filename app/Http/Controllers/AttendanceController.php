<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Classroom;
use App\SMS;
use App\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    //
    public function index(){
        $classrooms=Classroom::all();
        return view("attendance.index",compact('classrooms'));
    }


    public function markTodayAttendance($classroom_id){
        $i=0;
        $classroom=Classroom::find($classroom_id);
        if ($classroom->attendance_marked_today){
            return redirect()->back()->with('error','Attendance already marked');
        }
        $students=$classroom->Students;
        return view('attendance.mark-attendance',compact('students','i'));
    }


    public function viewTodayAttendance($classroom_id=null){
        if ($classroom_id==null){
            $attendances=Attendance::whereDate('created_at',Carbon::today())->with('student')->get();
        }
        else{
            $classroom=Classroom::find($classroom_id);
            $attendances=Attendance::whereIn('student_id',$classroom->Students()->get(['id'])->pluck('id'))
                ->whereDate('created_at',Carbon::today())->with('student')->get();
        }

        return view('attendance.view-class-attendance',compact('attendances','classroom_id'));
    }


    public function store(Request $request){
        foreach ($request->students as $id){
            if ($request->present){
                if (array_search($id,$request->present) || array_search($id,$request->present)===0){
                    Attendance::create(['student_id'=>$id,'present'=>1]);
                }
                else{
                    Attendance::create(['student_id'=>$id,'present'=>0]);
                }
            }
            else{
                Attendance::create(['student_id'=>$id,'present'=>0]);
            }
        }
        return redirect()->route('attendance.index')->with('success','attendance marked successfully');
    }


    public function update(Request $request){

            foreach ($request->attendances as $id){
                if ($request->present) {
                    if (array_search($id, $request->present)) {
                        Attendance::find($id)->update(['present' => 1]);
                    } else {
                        if (array_search($id, $request->present) === 0) {
                            Attendance::find($id)->update(['present' => 1]);
                        } else {
                            Attendance::find($id)->update(['present' => 0]);
                        }

                    }
                }
                else{
                    Attendance::find($id)->update(['present' => 0]);
                }
            }


        return redirect()->route('attendance.index')->with('success','attendance marked successfully');
    }

    public function sendSMS(Request $request,$classroom_id=null){
        if ($classroom_id==null){
            $attendances=Attendance::whereDate('created_at',Carbon::today())->where('present',0)->with('student')->get();
        }
        else{
            $classroom=Classroom::find($classroom_id);
            $attendances=Attendance::whereIn('student_id',$classroom->Students()->get(['id'])->pluck('id'))
                ->whereDate('created_at',Carbon::today())->where('present',0)->with('student')->get();
        }
        foreach ($attendances as $attendance){
            SMS::create(['number'=>$attendance->student->phone_number,'message'=>"Your child is absent from school today",'status'=>'pending']);
        }
        return "sms created successfully";
    }
}
