<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCesitFiyatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cesit_fiyat', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('urun_id')->unsigned();
            $table->bigInteger('cesit_detay_id')->unsigned();
            $table->bigInteger('ulke_id')->unsigned();
            $table->decimal('fiyat', 30, 2)->nullable();
            $table->decimal('fiyat_onceki', 30, 2)->nullable();
            $table->decimal('kdv_orani', 30, 2)->nullable();
            $table->tinyInteger('kdv_durum')->default(0);
            $table->decimal('kdvsiz_fiyat', 30, 2)->nullable();
            $table->decimal('fiyat_bir_kdvsiz', 30, 2)->nullable();
            $table->decimal('fiyat_bir', 30, 2)->nullable();
            $table->decimal('fiyat_bir_onceki', 30, 2)->nullable();
            $table->decimal('fiyat_iki_kdvsiz', 30, 2)->nullable();
            $table->decimal('fiyat_iki', 30, 2)->nullable();
            $table->decimal('fiyat_iki_onceki', 30, 2)->nullable();
            $table->decimal('fiyat_uc_kdvsiz', 30, 2)->nullable();
            $table->decimal('fiyat_uc', 30, 2)->nullable();
            $table->decimal('fiyat_uc_onceki', 30, 2)->nullable();
            $table->decimal('fiyat_dort_kdvsiz', 30, 2)->nullable();
            $table->decimal('fiyat_dort', 30, 2)->nullable();
            $table->decimal('fiyat_dort_onceki', 30, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('urun_id')->references('id')->on('urun')->onDelete('cascade');
            $table->foreign('cesit_detay_id')->references('id')->on('cesit_detay')->onDelete('cascade');
            $table->foreign('ulke_id')->references('id')->on('ulke')->onDelete('cascade');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cesit_fiyat');
    }
}
