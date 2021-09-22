<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteBanner2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_banner2', function (Blueprint $table) {
            $table->id();       
            $table->bigInteger('dil_id')->unsigned(); 
            $table->string('gorsel')->nullable();
            $table->string('gorsel2')->nullable();
            $table->string('baslik')->nullable();
            $table->string('baslik_alt')->nullable();
            $table->string('detay')->nullable();
            $table->string('buton_isim')->nullable();
            $table->string('buton_link')->nullable();
            $table->timestamps();
            $table->softDeletes(); 
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
        Schema::dropIfExists('site_banner2');
    }
}
