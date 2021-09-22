<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TopluUrunGrup extends Model
{
    use SoftDeletes;
    protected $table= 'toplu_urun_grup';

    protected $guarded = [];

    public function toplu_urun_getir(){
    	$dilId = $this->dilIdBul();
        return $this->hasMany('App\Models\TopluUrun', 'id', 'kategori_id');
    }
}
