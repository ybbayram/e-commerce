<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OneCikanlarUrun extends Model
{

   use SoftDeletes;
   protected $table= 'one_cikanlar_urun';
   protected $guarded = [];
   
   public function urun_getir(){
      return $this->hasOne('App\Models\Urun', 'id', 'urun_id');
   }
   
}
