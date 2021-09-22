<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnaylanmisIadelerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('onaylanmis_iadeler', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('iade_id')->unsigned();
            $table->tinyInteger('durum')->default(0);
            $table->timestamps();
            $table->foreign('iade_id')->references('id')->on('iade_talepleri')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('onaylanmis_iadeler');
    }
}
