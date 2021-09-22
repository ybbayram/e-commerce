<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SepetUygulananIndirim extends Model
{

    use SoftDeletes;
    protected $table= 'sepet_uygulanan_indirim';

    protected $guarded = [];

    public function kupon_kod_getir(){
        return $this->hasOne('App\Models\KuponKod', 'id', 'indirim_id');
    }

}
