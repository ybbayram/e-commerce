<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSepetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sepet', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ziyaretci_id')->unsigned();
            $table->bigInteger('ulke_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('ziyaretci_id')->references('id')->on('ziyaretci')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sepet');
    }
}
