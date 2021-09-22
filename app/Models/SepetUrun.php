<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cookie;
use App\Models\{Ziyaretci, Dil, UlkeKod, Ulke};

class SepetUrun extends Model
{
	use SoftDeletes;
	protected $table= 'sepet_urun';

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

	public function urun(){
		return $this->belongsTo('App\Models\Urun');
	}

	public function sepeturun_urun_getir(){
		return $this->hasOne('App\Models\Urun', 'id', 'urun_id');
	}

	public function sepeturun_urun_bul(){
		return $this->hasOne('App\Models\Urun', 'id', 'urun_id');
	}

	public function urun_slug(){
		return $this->hasOne('App\Models\Urun', 'id', 'urun_id')->select('slug');
	}

	public function detay_bul(){
		$dilId = $this->dilIdBul();
		return $this->hasOne('App\Models\UrunDetay', 'urun_id', 'urun_id')->where('dil_id', $dilId)->select('ad');
	} 

	public function gorsel_bul(){
		return $this->hasOne('App\Models\Gorsel', 'urun_id', 'urun_id')->select('gorsel');
	} 

	
	public function cesit_detay_siparis_bul(){
		return $this->hasone('App\Models\CesitDetay', 'id', 'cesit_detay_id');
	}

}
