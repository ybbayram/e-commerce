<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromosyonDetayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promosyon_detay', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('promosyon_id')->unsigned();
            $table->bigInteger('uygulanan_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('promosyon_id')->references('id')->on('promosyon')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promosyon_detay');
    }
}
