<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cookie;
use App\Models\{Ziyaretci, Dil, UlkeKod};

class IadeTalepleri extends Model
{
  use SoftDeletes;
  protected $table= 'iade_talepleri';
  protected $guarded = [];

  public function iade_kod(){
    return $this->hasOne('App\Models\IadeKod', 'iade_id', 'id');
  }
  
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
  
  public function kullanici_bul(){
    return $this->hasOne('App\User', 'id', 'user_id');
  }
  public function iade_soru_getir(){
   $dilId = $this->dilIdBul();
   return $this->hasOne('App\Models\IadeSorularDil', 'id', 'iade_sebebi')->where('dil_id', $dilId);
 }

 public function onaylanmis_iade_getir(){
   return $this->hasOne('App\Models\OnaylanmisIadeler', 'iade_id', 'id');
 }

}
