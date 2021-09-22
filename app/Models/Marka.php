<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cookie;
use App\Models\{Ziyaretci, Dil, UlkeKod};


class Marka extends Model
{
    use SoftDeletes;
    protected $table= 'marka';

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
public function marka_dil_getir(){
   $dilId = $this->dilIdBul(); 
   return $this->hasOne('App\Models\MarkaDil', 'marka_id', 'id')->where('dil_id', $dilId);
}

}
