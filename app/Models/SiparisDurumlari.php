<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiparisDurumlari extends Model
{
    
    use SoftDeletes;
    protected $table= 'siparis_durumlari';

    protected $guarded = [];
}
