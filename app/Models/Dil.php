<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dil extends Model
{
    use SoftDeletes;
    protected $table= 'dil';

    protected $guarded = [];

    public function ulke_kod_getir(){
        return $this->hasOne('App\Models\UlkeKod', 'id', 'ulke_kod_id');
    }
}
