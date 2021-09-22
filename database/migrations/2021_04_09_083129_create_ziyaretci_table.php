<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZiyaretciTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ziyaretci', function (Blueprint $table) {
            $table->id();
            $table->string('ip', 30);
            $table->smallInteger('dil_id')->unsigned();
            $table->smallInteger('ulke_id')->unsigned()->nullable();
            $table->string('token')->nullable();
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
        Schema::dropIfExists('ziyaretci');
    }
}
