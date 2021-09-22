<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSssDilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sss_dil', function (Blueprint $table) {
          $table->id();
          $table->bigInteger('dil_id')->unsigned();
          $table->bigInteger('sss_id')->unsigned();
          $table->string('icon')->nullable();
          $table->string('baslik');
          $table->string('aciklama'); 
          $table->tinyInteger('durum')->default(0);
          $table->timestamps();
          $table->softDeletes();
          $table->foreign('sss_id')->references('id')->on('sss')->onDelete('cascade');
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
        Schema::dropIfExists('sss_dil');
    }
}
