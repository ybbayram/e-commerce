<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KategoriAnaliz extends Model
{

    use SoftDeletes;
    protected $table= 'kategori_analiz';

    protected $guarded = [];


    public function kategori_getir(){
       return $this->hasOne('App\Models\Kategori', 'id', 'kategori_id');
   }

}
