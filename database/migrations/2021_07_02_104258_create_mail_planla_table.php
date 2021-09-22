<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailPlanlaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_planla', function (Blueprint $table) {
            $table->id();
            $table->string('ad', 60);
            $table->string('gunler');
            $table->time('saat')->nullable();
            $table->tinyInteger('mail_turu')->unsigned();
            $table->tinyInteger('durum')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mail_planla');
    }
}
