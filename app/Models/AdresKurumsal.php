<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdresKurumsal extends Model
{
  use SoftDeletes;
  protected $table= 'adres_kurumsal';

  protected $guarded = [];


}