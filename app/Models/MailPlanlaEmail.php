<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MailPlanlaEmail extends Model
{
    use SoftDeletes;
    protected $table= 'mail_planla_email';

    protected $guarded = [];
}
