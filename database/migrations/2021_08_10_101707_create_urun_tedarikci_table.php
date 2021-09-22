<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUrunTedarikciTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('urun_tedarikci', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('urun_id')->unsigned();
            $table->bigInteger('tedarikci_id')->unsigned();
            $table->bigInteger('cesit_detay_id')->unsigned()->nullable();
            $table->string('stok_kodu');
            $table->tinyInteger('durum')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('urun_id')->references('id')->on('urun')->onDelete('cascade');
            $table->foreign('tedarikci_id')->references('id')->on('tedarikci')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('urun_tedarikci');
    }
}
