<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Adres extends Model
{
    use SoftDeletes;
    protected $table= 'adres';

    protected $guarded = [];

    public function adres_kurumsal_getir(){
        return $this->hasOne('App\Models\AdresKurumsal', 'adres_id', 'id');
    }
    
    public function ulke_getir(){
        return $this->hasOne('App\Models\Ulke', 'id', 'ulke');
    }
}
