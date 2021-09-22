<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CesitFiyat extends Model
{

   use SoftDeletes;
   protected $table= 'cesit_fiyat';

   protected $guarded = [];
   public function ulke_getir(){
     return $this->hasOne('App\Models\Ulke', 'id', 'ulke_id');
  } 

  public function cesit_detay_bul(){
    return $this->hasone('App\Models\CesitDetay', 'id', 'cesit_detay_id');
 }

}
