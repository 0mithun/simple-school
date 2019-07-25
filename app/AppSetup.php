<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppSetup extends Model
{
    
    protected $table = 'app_setups';
    protected $primaryKey = 'app_setup_id';
    protected $fillable = ['app_title','app_description','copyright_title','app_logo','app_favicon'];
}
