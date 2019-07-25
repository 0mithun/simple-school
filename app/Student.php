<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';
    protected $primaryKey = 'student_id';
    protected $fillable = ['student_name','date_of_birth','age','email','contact','address', 'city','country','date_of_register','class_id','section_id','student_photo'];
}
