<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSozlesmelerDilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sozlesmeler_dil', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('dil_id')->unsigned();
            $table->bigInteger('sozlesme_id')->unsigned();
            $table->string('baslik');
            $table->text('aciklama'); 
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('sozlesme_id')->references('id')->on('sozlesmeler')->onDelete('cascade');
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
        Schema::dropIfExists('sozlesmeler_dil');
    }
}
