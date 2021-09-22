<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOneCikanlarUrunTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('one_cikanlar_urun', function (Blueprint $table) {
         $table->id();
         $table->bigInteger('one_cikan_id')->unsigned();
         $table->bigInteger('urun_id')->unsigned();
         $table->timestamps();
         $table->softDeletes();
         $table->foreign('urun_id')->references('id')->on('urun')->onDelete('cascade');
         $table->foreign('one_cikan_id')->references('id')->on('one_cikanlar')->onDelete('cascade');
     });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('one_cikanlar_urun');
    }
}
