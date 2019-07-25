<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendances';
    protected $primaryKey = 'attendance_id';
    protected $fillable = ['attendance_type','teacher_id','student_id','class_id','section_id','attendance_date','attendance_status'];
}
