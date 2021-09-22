<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UrunDetay extends Model
{
    use SoftDeletes;
    protected $table= 'urun_detay';

    protected $guarded = [];

     public function dil_bul(){
        return $this->hasOne('App\Models\Dil', 'id', 'dil_id');
    }
}
