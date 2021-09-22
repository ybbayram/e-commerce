<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PromosyonUrun extends Model
{
    use SoftDeletes;
    protected $table= 'promosyon_urun';

    protected $guarded = [];

}
