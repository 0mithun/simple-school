<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResultSetting extends Model
{
    protected $table = 'result_settings';
    protected $primaryKey = 'result_setting_id';
    protected $fillable = ['class_id','exam_id','subject_id','mark_greater_than','mark_less_than','grade'];
}
