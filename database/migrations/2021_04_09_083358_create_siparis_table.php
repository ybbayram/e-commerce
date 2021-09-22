<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiparisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siparis', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sepet_id')->unsigned();
            $table->bigInteger('sepet_odeme_id')->unsigned();
            $table->bigInteger('ziyaretci_id');
            $table->bigInteger('adres_id')->nullable();
            $table->bigInteger('fatura_adres_id')->nullable();
            $table->tinyInteger('durum')->default(0);
            $table->tinyInteger('islem_durum')->default(0);
            $table->tinyInteger('platform')->default(10);
            $table->string('kargo_kod')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unique('sepet_id');
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
        Schema::dropIfExists('siparis');
    }
}
