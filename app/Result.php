<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $table = 'student_marks';
    protected $primaryKey = 'student_mark_id';
    protected $fillable = ['exam_id','class_id','student_id','mark','subject_id'];
}
