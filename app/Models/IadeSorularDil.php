<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IadeSorularDil extends Model
{

  use SoftDeletes;
  protected $table= 'iade_sorular_dil';
  protected $guarded = [];
  
  public function dil_bul(){
   return $this->hasOne('App\Models\Dil', 'id', 'dil_id');
 }

}
