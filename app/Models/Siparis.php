<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siparis extends Model
{
    use SoftDeletes;
    protected $table= 'siparis';

    protected $guarded = [];

    public function siparis_sepet_getir(){
        return $this->hasOne('App\Models\Sepet', 'id', 'sepet_id');
    }

    public function siparis_iade_getir(){
        return $this->hasOne('App\Models\IadeTalepleri', 'siparis_id', 'id');
    }
    public function adres_bul(){
        return $this->hasOne('App\Models\Adres', 'id', 'adres_id');
    }

    public function fatura_adres_bul(){
        return $this->hasOne('App\Models\Adres', 'id', 'fatura_adres_id');
    }
    
    public function sepet_urun_getir(){
        return $this->hasMany('App\Models\SepetUrun', 'sepet_id', 'sepet_id');
    }
    public function odeme_getir(){
        return $this->hasOne('App\Models\SepetOdeme', 'sepet_id', 'sepet_id');
    }
    public function durum_getir(){
        return $this->hasOne('App\Models\SiparisDurumlari', 'durum_id', 'islem_durum');
    }
}
