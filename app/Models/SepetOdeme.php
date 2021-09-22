<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SepetOdeme extends Model
{
    use SoftDeletes;
    protected $table= 'sepet_odeme';

    protected $guarded = [];


    public function sepet_getir(){
        return $this->hasOne('App\Models\Sepet', 'id', 'sepet_id');
    }
}
