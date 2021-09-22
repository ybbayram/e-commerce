<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UrunFiyat extends Model
{
    use SoftDeletes;
    protected $table= 'urun_fiyat';

    protected $guarded = [];

    public function ulke_getir(){
        return $this->hasOne('App\Models\Ulke', 'id', 'ulke_id');
    } 
}
