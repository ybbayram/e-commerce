<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCesitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cesit', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('urun_id')->unsigned();
            $table->string('baslik');
            $table->tinyInteger('durum')->default(0);
            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists('cesit');
    }
}
