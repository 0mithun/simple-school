<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    
    protected $table = 'exams';
    protected $primaryKey = 'exam_id';
    protected $fillable = ['exam_name','exam_year'];
}
