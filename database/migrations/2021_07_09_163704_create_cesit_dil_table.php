<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCesitDilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cesit_dil', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cesit_id')->unsigned();
            $table->bigInteger('dil_id')->unsigned();
            $table->string('ad');
            $table->timestamps();
            $table->softDeletes(); 
            $table->foreign('cesit_id')->references('id')->on('cesit')->onDelete('cascade');
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
        Schema::dropIfExists('cesit_dil');
    }
}
