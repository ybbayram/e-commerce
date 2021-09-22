<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cookie;
use App\Models\{Ziyaretci, Dil, UlkeKod};

class Kategori extends Model
{
    use SoftDeletes;
    protected $table= 'kategori';

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

public function kategori_dil_getir(){
 $dilId = $this->dilIdBul();
 return $this->hasOne('App\Models\KategoriDil', 'kategori_id', 'id')->where('dil_id', $dilId);
}


public function kategori_urun_getir(){ 
 return $this->hasMany('App\Models\UrunKategori', 'kategori_id', 'id');
}

public function kategori_alt_getir(){
 return $this->hasMany('App\Models\Kategori', 'ust_id', 'id')->orderBy('sira', 'asc');
}

}
