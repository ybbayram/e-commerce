<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiteSliderDil extends Model
{
  use SoftDeletes;
  protected $table= 'site_slider_dil';
  protected $guarded = [];

  public function dil_bul(){
    return $this->hasOne('App\Models\Dil', 'id', 'dil_id');
}

}
