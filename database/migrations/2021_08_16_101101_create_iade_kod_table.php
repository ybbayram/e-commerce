<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIadeKodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iade_kod', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('iade_id')->unsigned();
            $table->bigInteger('kargo_firma_id')->unsigned();
            $table->string('kargo_kod');
            $table->timestamps();
            $table->foreign('iade_id')->references('id')->on('iade_talepleri')->onDelete('cascade');
            $table->foreign('kargo_firma_id')->references('id')->on('kargo_firma')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('iade_kod');
    }
}
