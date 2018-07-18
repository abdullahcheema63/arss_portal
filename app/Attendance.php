<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    //
    protected $fillable=['student_id','present'];
    public function student(){
        return $this->belongsTo("App\Student");
    }
}
