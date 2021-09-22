<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UrunAnaliz extends Model
{
    use SoftDeletes;
    protected $table= 'urun_analiz';

    protected $guarded = [];
}
