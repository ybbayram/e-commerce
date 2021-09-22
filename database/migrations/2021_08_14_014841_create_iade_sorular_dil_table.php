<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIadeSorularDilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iade_sorular_dil', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('dil_id')->unsigned();
            $table->bigInteger('iade_soru_id')->unsigned();
            $table->text('aciklama')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('iade_soru_id')->references('id')->on('iade_sorular')->onDelete('cascade');
            $table->foreign('dil_id')->references('id')->on('dil')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('iade_sorular_dil');
    }
}
