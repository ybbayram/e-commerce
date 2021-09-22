<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSepetOdemeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sepet_odeme', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sepet_id')->unsigned();
            $table->decimal('indirimTutari', 30,2)->nullable();
            $table->decimal('SepetindirimTutari', 30,2)->nullable();
            $table->decimal('indirimXalYode', 30,2)->nullable();
            $table->decimal('toplam', 30,2)->nullable();
            $table->decimal('kargoFiyat', 30,2)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('sepet_id')->references('id')->on('sepet')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sepet_odeme');
    }
}
