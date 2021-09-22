<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gorsel extends Model
{
    use SoftDeletes;
    protected $table= 'gorsel';

    protected $guarded = [];
}
