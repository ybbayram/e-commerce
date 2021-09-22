<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UrunHaberVer extends Model
{

    protected $table= 'urun_haber_ver';

    protected $guarded = [];

    public function kullanici_bul(){ 
        return $this->hasOne('App\User', 'id', 'user_id');
    } 

}
