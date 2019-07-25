<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $table = 'sections';
    protected $primaryKey = 'section_id';
    protected $fillable = ['section_name','class_id','teacher_id'];
}
