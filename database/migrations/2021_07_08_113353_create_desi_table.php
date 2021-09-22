<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDesiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('desi', function (Blueprint $table) {
         $table->id();
         $table->bigInteger('urun_id')->unsigned();
         $table->decimal('en', 30, 2)->nullable();
         $table->decimal('boy', 30, 2)->nullable();
         $table->decimal('yukseklik', 30, 2)->nullable();
         $table->decimal('kilogram', 30, 2)->nullable();
         $table->decimal('desi', 30, 2)->nullable();
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
        Schema::dropIfExists('desi');
    }
}
