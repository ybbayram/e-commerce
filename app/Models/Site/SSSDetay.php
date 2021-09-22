<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cookie;
use App\Models\{Ziyaretci, Dil, UlkeKod};

class SSSDetay extends Model
{

    protected $table= 'sss_detay';

    protected $guarded = [];
    use SoftDeletes;


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

  public function sss_detay_dil_getir(){
     $dilId = $this->dilIdBul();
     return $this->hasOne('App\Models\Site\SSSDetayDil', 'sss_detay_id', 'id')->where('dil_id', $dilId);
 }

}
