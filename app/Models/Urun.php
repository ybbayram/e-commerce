<?php

namespace App\Models;

use App\GenelFonksiyonlar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cookie;
use App\User;
use App\Models\{Ziyaretci, Dil, UlkeKod, Ulke, ZiyaretciUser};

class Urun extends Model
{
    use SoftDeletes;
    protected $table= 'urun';

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

public function ulkeIdBul(){

 $ipUlke = GenelFonksiyonlar::getIp();
 $ip = $ipUlke['ip'];
 $ulkeKod = $ipUlke['ulkeKod'];

 $ulkeKod = UlkeKod::where('kod', $ulkeKod)->first();
 $ulke = Ulke::where('ulke_kod_id', $ulkeKod->id)->first();
 return $ulke->id;
}

public function gorsel_bul(){ 
    return $this->hasOne('App\Models\Gorsel', 'urun_id', 'id')->orderBy('sira', 'asc');
} 
public function urun_gorsel_bul(){
    return $this->hasOne('App\Models\Gorsel', 'urun_id', 'id')->orderBy('sira', 'asc');
} 

public function gorseller_bul(){
    return $this->hasMany('App\Models\Gorsel', 'urun_id', 'id')->orderBy('sira', 'asc');
} 
public function urun_gorseller_bul(){
    return $this->hasMany('App\Models\Gorsel', 'urun_id', 'id')->orderBy('sira', 'asc');
} 

public function marka_bul(){
    return $this->hasOne('App\Models\Marka', 'id', 'marka');
} 

public function fiyat_bul(){
    $ulkeId = $this->ulkeIdBul();
    return $this->hasOne('App\Models\UrunFiyat', 'urun_id', 'id')->where('ulke_id', $ulkeId);
} 
public function urun_fiyat_bul(){
    $ulkeId = $this->ulkeIdBul();
    return $this->hasOne('App\Models\UrunFiyat', 'urun_id', 'id')->where('ulke_id', $ulkeId);
} 

public function detay_bul(){
    $dilId = $this->dilIdBul();
    return $this->hasOne('App\Models\UrunDetay', 'urun_id', 'id')->where('dil_id', $dilId);
} 
public function urun_detay_bul(){
    $dilId = $this->dilIdBul();
    return $this->hasOne('App\Models\UrunDetay', 'urun_id', 'id')->where('dil_id', $dilId);
} 

public function cesit_bul(){
    return $this->hasone('App\Models\Cesit', 'urun_id', 'id')->where('cesit.durum', 1);
}

public function cesitler_bul(){
    return $this->hasMany('App\Models\Cesit', 'urun_id', 'id')->where('cesit.durum', 1);
}

public function cesit_detay_bul(){
    return $this->hasone('App\Models\CesitDetay', 'cesit_id', 'id')->where('cesit_detay.durum', 1);
}
public function cesit_fiyat_bul(){
    $ulkeId = $this->ulkeIdBul();
    return $this->hasOne('App\Models\cesitFiyat', 'cesit_detay_id', 'id')->where('ulke_id', $ulkeId);
} 

public function urun_analiz_bul(){
    return $this->hasOne('App\Models\UrunAnaliz', 'urun_id', 'id');
} 
public function urun_tedarikci_getir(){
    return $this->hasMany('App\Models\UrunTedarikci', 'urun_id', 'id');
}
public function urun_favori(){
  $ziyaretciId = Cookie::get('ziyaretci_id');
  $user_id = auth()->id();
  if (isset($user_id)) {  
      $user = ZiyaretciUser::where('ziyaretci_id', $ziyaretciId)->first();
      $user_id = $user->user_id;
      $ziyaretciler = ZiyaretciUser::where('user_id', $user_id)->get();
      foreach($ziyaretciler as $ziyaretci){
        $ziyaretci_id[] = $ziyaretci->ziyaretci_id;

    }
}else{
    $ziyaretci_id[] = $ziyaretciId;
}
return $this->hasOne('App\Models\Favori', 'urun_id', 'id')->whereIn('favori.ziyaretci_id', $ziyaretci_id);
}
}
