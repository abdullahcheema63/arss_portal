<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    //
    protected $fillable=['name'];
    public function Students(){
        return $this->hasMany(Student::class);
    }
}
