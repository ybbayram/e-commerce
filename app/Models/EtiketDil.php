<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EtiketDil extends Model
{
    use SoftDeletes;
    protected $table= 'etiket_dil';
    protected $guarded = [];
    
    public function dil_bul(){
        return $this->hasOne('App\Models\Dil', 'id', 'dil_id');
    }
}
