<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tedarikci extends Model
{
    use SoftDeletes;
    protected $table= 'tedarikci';

    protected $guarded = [];

    public function tedarikci_urun_var_mi(){
        return $this->hasOne('App\Models\UrunTedarikci', 'tedarikci_id', 'id');
    }

}
