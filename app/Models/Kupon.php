<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kupon extends Model
{

   use SoftDeletes;
   protected $table= 'kupon';

   protected $guarded = [];

   public function kupon_kullanimi(){
    return $this->hasMany('App\Models\KuponKod', 'kupon_id', 'id')->where('kullanim_durumu', 1);
}
}
