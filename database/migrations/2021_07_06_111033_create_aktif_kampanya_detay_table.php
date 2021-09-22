<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAktifKampanyaDetayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aktif_kampanya_detay', function (Blueprint $table) {
         $table->id();
         $table->bigInteger('aktif_kampanya_id')->unsigned();
         $table->bigInteger('uygulanan_id')->unsigned();
         $table->softDeletes();
         $table->timestamps();
         $table->foreign('aktif_kampanya_id')->references('id')->on('aktif_kampanya')->onDelete('cascade');
     });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aktif_kampanya_detay');
    }
}
