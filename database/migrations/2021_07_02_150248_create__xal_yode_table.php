<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXalYodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('x_al_y_ode', function (Blueprint $table) {
            $table->id();
            $table->string('ad');
            $table->tinyInteger('tur')->unsigned();
            $table->integer('min')->unsigned();
            $table->integer('adet_yuzde')->unsigned();
            $table->tinyInteger('grup')->unsigned();
            $table->timestamp('baslangic_tarihi')->nullable();
            $table->timestamp('bitis_tarihi')->nullable();
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
        Schema::dropIfExists('x_al_y_ode');
    }
}
