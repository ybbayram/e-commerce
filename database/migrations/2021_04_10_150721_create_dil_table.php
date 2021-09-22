<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dil', function (Blueprint $table) {
            $table->id();
            $table->string('ad', 100)->nullable();
            $table->string('gorunur_ad', 100)->nullable();
            $table->bigInteger('ulke_kod_id')->unsigned()->nullable();
            $table->json('json')->nullable();
            $table->tinyInteger('durum')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dil');
    }
}
