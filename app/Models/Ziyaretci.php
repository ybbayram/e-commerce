<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ziyaretci extends Model
{
    use SoftDeletes;
    protected $table= 'ziyaretci';

    protected $guarded = [];
}
