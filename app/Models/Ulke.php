<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ulke extends Model
{
    use SoftDeletes;
    protected $table= 'ulke';

    protected $guarded = [];

    public function ulke_kod_getir(){
        return $this->hasOne('App\Models\UlkeKod', 'id', 'ulke_kod_id');
    }

    public function para_birimi_getir(){
        return $this->hasOne('App\Models\ParaBirimi', 'id', 'para_birimi_id');
    }
}
