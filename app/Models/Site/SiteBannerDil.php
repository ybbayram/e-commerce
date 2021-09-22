<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class SiteBannerDil extends Model
{

  use SoftDeletes;
  protected $table= 'site_banner_dil';
  protected $guarded = [];

  public function dil_bul(){
    return $this->hasOne('App\Models\Dil', 'id', 'dil_id');
}
}
