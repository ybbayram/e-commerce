<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUrunAnalizTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('urun_analiz', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('urun_id')->unsigned();
            $table->integer('toplam_puan')->unsigned()->default(0);
            $table->integer('oy_sayi')->unsigned()->default(0);
            $table->decimal('ortalama_puan', 30, 2)->unsigned()->default(0);
            $table->integer('tiklama')->unsigned()->default(0);
            $table->integer('mobil_tiklama')->unsigned()->default(0);
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
        Schema::dropIfExists('urun_analiz');
    }
}
