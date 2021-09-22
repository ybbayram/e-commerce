<?php

namespace App\Models\Site;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Cookie;
use App\Models\{Ziyaretci, Dil, UlkeKod};

class SiteSlider extends Model
{

    protected $table= 'site_slider';

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
  public function slider_dil_getir(){
   $dilId = $this->dilIdBul();
   return $this->hasOne('App\Models\Site\SiteSliderDil', 'slider_id', 'id')->where('dil_id', $dilId);
}

}
