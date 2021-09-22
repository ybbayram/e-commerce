<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KuponKod extends Model
{
   protected $table= 'kupon_kod';

   protected $guarded = [];

   public function kupon_getir(){
      return $this->hasOne('App\Models\Kupon', 'id', 'kupon_id');
   }

}
