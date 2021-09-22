<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class UrunTedarikci extends Model
{
 use SoftDeletes;
 protected $table= 'urun_tedarikci';

 protected $guarded = [];

 public function tedarikci_getir(){
    return $this->hasOne('App\Models\Tedarikci', 'id', 'tedarikci_id');
}

public function cesit_detay_bul(){
    return $this->hasMany('App\Models\CesitDetay', 'id', 'cesit_detay_id');
}

}
