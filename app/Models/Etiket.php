<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cookie;
use App\Models\{Ziyaretci, Dil, UlkeKod};

class Etiket extends Model
{  
  use SoftDeletes;
  protected $table= 'etiket';
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

  public function urun_etiket_dil_getir(){
   $dilId = $this->dilIdBul();
   return $this->hasOne('App\Models\EtiketDil', 'etiket_id', 'etiket_id')->where('dil_id', $dilId);
 }

 public function etiket_dil_getir(){
   $dilId = $this->dilIdBul();
   return $this->hasOne('App\Models\EtiketDil', 'etiket_id', 'id')->where('dil_id', $dilId);
 }


}
