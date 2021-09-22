<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAktifKampanyaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aktif_kampanya', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ulke_id')->unsigned();
            $table->bigInteger('grup')->unsigned();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('ulke_id')->references('id')->on('ulke')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aktif_kampanya');
    }
}
