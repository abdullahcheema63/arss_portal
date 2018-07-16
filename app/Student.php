<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //
    protected $fillable=['name','father_name','address','phone_number','classroom_id'];
    public function Classroom(){
        return $this->belongsTo(Classroom::class);
    }
}
