<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cookie;
use App\Models\{Ziyaretci, Dil, UlkeKod};


class Filtre extends Model
{    
    use SoftDeletes;
    protected $table= 'filtre';
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

public function filtre_dil_getir(){
 $dilId = $this->dilIdBul();
 return $this->hasOne('App\Models\FiltreDil', 'filtre_id', 'filtre_id')->where('dil_id', $dilId);
}
public function urun_filtre_dil_getir(){
 $dilId = $this->dilIdBul();
 return $this->hasOne('App\Models\FiltreDil', 'filtre_id', 'id')->where('dil_id', $dilId);
}

public function filtre_kategori_getir(){
 $dilId = $this->dilIdBul();
 return $this->hasOne('App\Models\FiltreKategori', 'filtre_id', 'id')->where('dil_id', $dilId);
}

public function filtre_kategori_alt_getir(){
    return $this->hasMany('App\Models\FiltreAlt', 'filtre_id', 'id');
} 
public function filtre_etiket_getir(){
    return $this->hasMany('App\Models\FiltreEtiket', 'filtre_id', 'filtre_id')
    ->join('etiket', 'filtre_etiket.etiket_id', '=', 'etiket.id')
    ->where('filtre_etiket.deleted_at', '=', null)
    ->where('durum', 1)
    ->orderBy('sira', 'asc');
} 

} 
