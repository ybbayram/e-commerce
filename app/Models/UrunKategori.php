<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UrunKategori extends Model
{
    use SoftDeletes;
    protected $table= 'urun_kategori';

    protected $guarded = [];

    public function kategori_bul(){
        return $this->hasOne('App\Models\Kategori', 'id', 'kategori_id');
    } 
    public function urun_bul(){
        return $this->hasMany('App\Models\Urun', 'id', 'urun_id')->where('durum',1);
    } 
}
