<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MailPlanla extends Model
{
    use SoftDeletes;
    protected $table= 'mail_planla';

    protected $guarded = [];

    public function mail_plan_email_getir(){
       return $this->hasMany('App\Models\MailPlanlaEmail', 'mail_planla', 'id');
   }
}
