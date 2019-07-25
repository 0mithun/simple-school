<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marks extends Model
{
    protected $table = 'marks';
    protected $primaryKey = 'mark_id';
    protected $fillable = ['total_mark','pass_mark','exam_id','class_id','subject_id'];
}
