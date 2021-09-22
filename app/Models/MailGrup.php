<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MailGrup extends Model
{
    use SoftDeletes;
    protected $table= 'mail_gruplari';

    protected $guarded = [];
}
