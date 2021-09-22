<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ZiyaretciUser extends Model
{

    use SoftDeletes;
    protected $table= 'ziyaretci_user';

    protected $guarded = [];

}
