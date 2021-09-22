<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteSliderDilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_slider_dil', function (Blueprint $table) {
            $table->id();       
            $table->bigInteger('dil_id')->unsigned();
            $table->bigInteger('slider_id')->unsigned();
            $table->string('gorsel')->nullable();
            $table->string('gorsel_mobil')->nullable();
            $table->string('gorsel_3')->nullable();
            $table->string('baslik')->nullable();
            $table->string('detay')->nullable();
            $table->string('buton_baslik')->nullable();
            $table->string('buton_link')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('slider_id')->references('id')->on('site_slider')->onDelete('cascade');
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
        Schema::dropIfExists('site_slider_dil');
    }
}
