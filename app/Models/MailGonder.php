<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MailGonder extends Model
{
    use SoftDeletes;
    protected $table= 'mail_gonder';

    protected $guarded = [];

    public function mail_grubu_getir(){
        return $this->hasOne('App\Models\MailGrup', 'id', 'mail_gruplari_id');
    }
}
