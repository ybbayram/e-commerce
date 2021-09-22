<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cookie;
use App\Models\{Ziyaretci, Dil, UlkeKod};

class Cesit extends Model
{

  use SoftDeletes;
  protected $table= 'cesit';

  protected $guarded = [];

  public function dilIdBul(){
    $ziyaretciId = Cookie::get('ziyaretci_id');
    $ziyaretci = Ziyaretci::where('id', $ziyaretciId)->orderBy('created_at', 'DESC')->first();
    if(isset($ziyaretci)){
      $dil = $ziyaretci->dil_id;
      return $dil;
    }else{
      $ulkeKod = UlkeKod::where('kod', 'TR')->first();
      $dil = Dil::where('ulke_kod_id', $ulkeKod->id)->first();
      return $dil->id;
    }

  }

  public function cesit_dil_getir(){
   $dilId = $this->dilIdBul();
   return $this->hasOne('App\Models\CesitDil', 'cesit_id', 'id')->where('dil_id', $dilId);
 }

 public function cesit_detay_bul(){
  return $this->hasMany('App\Models\CesitDetay', 'cesit_id', 'id')->where('cesit_detay.durum', 1);
 }


}
