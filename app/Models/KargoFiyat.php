<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KargoFiyat extends Model
{

 use SoftDeletes;
 protected $table= 'kargo_fiyat';

 protected $guarded = [];
}
