<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnaylanmisIadeler extends Model
{

    protected $table= 'onaylanmis_iadeler';
    protected $guarded = [];
    
    public function iade_getir(){
        return $this->hasOne('App\Models\IadeTalepleri', 'id', 'iade_id');
    }
}
