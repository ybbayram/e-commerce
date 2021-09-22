<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FiltreEtiket extends Model
{
    use SoftDeletes;
    protected $table= 'filtre_etiket';
    protected $guarded = [];

    public function filtre_etiket_etiket_bul(){
        return $this->hasone('App\Models\Etiket', 'id', 'etiket_id');
    }
}
