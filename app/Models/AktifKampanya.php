<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AktifKampanya extends Model
{
   use SoftDeletes;
   protected $table= 'aktif_kampanya';

   protected $guarded = [];
}
