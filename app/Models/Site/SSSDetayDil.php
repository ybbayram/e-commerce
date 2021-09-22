<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SSSDetayDil extends Model
{
  use SoftDeletes;
  protected $table= 'sss_detay_dil';
  protected $guarded = [];

  public function dil_bul(){
    return $this->hasOne('App\Models\Dil', 'id', 'dil_id');
}
}
