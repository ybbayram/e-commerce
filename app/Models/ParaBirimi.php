<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParaBirimi extends Model
{
    use SoftDeletes;
    protected $table= 'para_birimleri';

    protected $guarded = [];
}
