<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TopluUrun extends Model
{
    use SoftDeletes;
    protected $table= 'toplu_urun_grup';

    protected $guarded = [];
}
