<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromosyonUrunTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promosyon_urun', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('promosyon_id')->unsigned();
            $table->bigInteger('urun_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('promosyon_id')->references('id')->on('promosyon')->onDelete('cascade');
            $table->foreign('urun_id')->references('id')->on('urun')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promosyon_urun');
    }
}
