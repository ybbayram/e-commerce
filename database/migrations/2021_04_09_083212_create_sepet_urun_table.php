<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSepetUrunTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sepet_urun', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sepet_id')->unsigned();
            $table->bigInteger('urun_id')->unsigned();
            $table->bigInteger('cesit_detay_id')->nullable();
            $table->integer('adet')->unsigned();
            $table->decimal('fiyati', 30, 2);
            $table->tinyInteger('promosyonMu')->default(null);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('sepet_id')->references('id')->on('sepet')->onDelete('cascade');
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
        Schema::dropIfExists('sepet_urun');
    }
}
