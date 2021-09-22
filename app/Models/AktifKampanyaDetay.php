<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AktifKampanyaDetay extends Model
{

   use SoftDeletes;
   protected $table= 'aktif_kampanya_detay';

   protected $guarded = [];
}
