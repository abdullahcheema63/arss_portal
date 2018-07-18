<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    //
    protected $fillable=['name'];
    protected $appends=['attendance_marked_today'];
    public function getAttendanceMarkedTodayAttribute(){
        return ($this->Students()->count()<=
            Attendance::whereIn('student_id',$this->Students()->get(['id'])->pluck('id'))
                ->whereDate('created_at',Carbon::today())->count())&&$this->Students()->count()!=0;
    }

    public function Students(){
        return $this->hasMany(Student::class);
    }
}
