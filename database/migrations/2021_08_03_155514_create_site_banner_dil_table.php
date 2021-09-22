<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteBannerDilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_banner_dil', function (Blueprint $table) {
            $table->id();       
            $table->bigInteger('dil_id')->unsigned();
            $table->bigInteger('banner_id')->unsigned();
            $table->string('gorsel')->nullable();
            $table->string('baslik')->nullable();
            $table->string('buton_link')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('banner_id')->references('id')->on('site_banner')->onDelete('cascade');
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
        Schema::dropIfExists('site_banner_dil');
    }
}
