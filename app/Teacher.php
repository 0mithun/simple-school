<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $table = 'teachers';
    protected $fillable = ['name', 'email','date_of_birth','age','contact','address','city','country','job_type','photo'];
    //protected $fillable = ['name','date_of_birth'];
    protected $primaryKey  = 'teacher_id';
}
