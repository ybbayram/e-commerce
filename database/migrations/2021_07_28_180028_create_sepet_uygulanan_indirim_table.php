<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSepetUygulananIndirimTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sepet_uygulanan_indirim', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sepet_id')->unsigned();
            $table->bigInteger('indirim_id')->unsigned();
            $table->bigInteger('indirim_turu')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('sepet_id')->references('id')->on('sepet')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sepet_uygulanan_indirim');
    }
}
