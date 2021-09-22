<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SepetIndirim extends Model
{
   use SoftDeletes;
   protected $table= 'sepet_indirim';

   protected $guarded = [];
}