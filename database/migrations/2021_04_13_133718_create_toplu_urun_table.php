<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopluUrunTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('toplu_urun', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('urun_id')->unsigned();
            $table->bigInteger('grup')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('urun_id')->references('id')->on('urun')->onDelete('cascade');
            $table->foreign('grup')->references('id')->on('toplu_urun_grup')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('toplu_urun');
    }
}
