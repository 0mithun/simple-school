<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    protected $primaryKey   =   'class_id';
    protected $table = 'tbl_classes';
    
    protected $fillable = ['class_name','class_numaric'];
    
}
