<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Yorum extends Model
{
    use SoftDeletes;
    protected $table= 'yorum';

    protected $guarded = [];

    public function urun_bul(){
        return $this->hasOne('App\Models\Urun', 'id', 'urun_id');
    }

    public function kullanici_bul(){
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
