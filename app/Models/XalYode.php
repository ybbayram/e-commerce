<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class XalYode extends Model
{

    use SoftDeletes;
    protected $table= 'x_al_y_ode';

    protected $guarded = [];
    
}
