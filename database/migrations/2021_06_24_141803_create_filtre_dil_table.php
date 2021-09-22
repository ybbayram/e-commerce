<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFiltreDilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filtre_dil', function (Blueprint $table) {
         $table->id();
         $table->string('ad', 60);
         $table->bigInteger('filtre_id')->unsigned();
         $table->bigInteger('dil_id')->unsigned();
         $table->timestamps();
         $table->softDeletes();
         $table->foreign('filtre_id')->references('id')->on('filtre')->onDelete('cascade');
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
        Schema::dropIfExists('filtre_dil');
    }
}
