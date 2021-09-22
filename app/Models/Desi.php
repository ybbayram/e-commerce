<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Desi extends Model
{
    use SoftDeletes;
    protected $table= 'desi';

    protected $guarded = [];
}
