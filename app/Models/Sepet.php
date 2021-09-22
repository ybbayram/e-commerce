<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Cookie;
use App\Models\{Sepet, Ziyaretci};

class Sepet extends Model
{
    use SoftDeletes;
    protected $table= 'sepet';

    protected $guarded = [];

    public function sepet_urunler(){
        return $this->hasMany('App\Models\SepetUrun');
    }

    public static function aktif_sepet_id(){
        $ziyaretciId = Cookie::get('ziyaretci_id'); 

        $aktif_sepet = Sepet::where('ziyaretci_id', $ziyaretciId)
        ->orderBy('created_at', 'DESC')
        ->select('id')
        ->first();

        if (!is_null($aktif_sepet)) return $aktif_sepet->id;
    }

    public static function aktif_sepet_id_mobil($token){
        $ziyaretci = Ziyaretci::where('token', $token)->first(); 
        
        $aktif_sepet = Sepet::where('ziyaretci_id', $ziyaretci->id)
        ->orderBy('created_at', 'desc')
        ->select('id')
        ->first();

        if (!is_null($aktif_sepet)) return $aktif_sepet->id;
    }

    public function sepet_urun_getir(){
        return $this->hasMany('App\Models\SepetUrun', 'sepet_id', 'id');
    }
    
    public function sepet_odeme_getir(){
        return $this->hasOne('App\Models\SepetOdeme', 'sepet_id', 'id');
    }
    
    public function para_simge_getir(){
        return $this->hasOne('App\Models\Ulke', 'id', 'ulke_id');
    }
}
