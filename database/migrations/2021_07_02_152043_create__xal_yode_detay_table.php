<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXalYodeDetayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('x_al_y_ode_detay', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('XalYode_id')->unsigned();
            $table->bigInteger('uygulanan_id')->unsigned();
            $table->timestamps();
            $table->foreign('XalYode_id')->references('id')->on('x_al_y_ode')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('x_al_y_ode_detay');
    }
}
