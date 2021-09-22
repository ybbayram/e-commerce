<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGorselTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gorsel', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('urun_id')->unsigned()->nullable();
            $table->string('gorsel')->nullable();
            $table->string('eski_ad')->nullable();
            $table->smallInteger('sira')->unsigned()->nullable();
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
        Schema::dropIfExists('gorsel');
    }
}
