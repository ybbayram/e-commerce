<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class SiteBanner2 extends Model
{
  use SoftDeletes;
  protected $table= 'site_banner2';
  protected $guarded = [];

  public function dil_bul(){
    return $this->hasOne('App\Models\Dil', 'id', 'dil_id');
}
}
