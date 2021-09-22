<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCesitDesiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cesit_desi', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cesit_detay_id')->unsigned();
            $table->decimal('en', 30, 2)->nullable();
            $table->decimal('boy', 30, 2)->nullable();
            $table->decimal('yukseklik', 30, 2)->nullable();
            $table->decimal('kilogram', 30, 2)->nullable();
            $table->decimal('desi', 30, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('cesit_detay_id')->references('id')->on('cesit_detay')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cesit_desi');
    }
}
