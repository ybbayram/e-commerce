<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSssDetayDilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sss_detay_dil', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('dil_id')->unsigned();
            $table->bigInteger('sss_detay_id')->unsigned();
            $table->string('baslik')->nullable();
            $table->text('aciklama')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('sss_detay_id')->references('id')->on('sss_detay')->onDelete('cascade');
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
        Schema::dropIfExists('sss_detay_dil');
    }
}
