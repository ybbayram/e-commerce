<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Favori extends Model
{
    use SoftDeletes;
    protected $table= 'favori';

    protected $guarded = [];

    public function favoriden_urun_bul(){
        return $this->hasOne('App\Models\Urun', 'id', 'urun_id');
    }
}
