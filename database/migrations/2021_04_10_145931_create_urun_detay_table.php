<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUrunDetayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('urun_detay', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('urun_id')->unsigned();
            $table->smallInteger('dil_id')->unsigned();
            $table->string('ad', 150);
            $table->text('aciklama_bir')->nullable();
            $table->string('aciklama_bir_baslik')->nullable();
            $table->text('aciklama_iki')->nullable();
            $table->string('aciklama_iki_baslik')->nullable();
            $table->text('aciklama_uc')->nullable();
            $table->string('aciklama_uc_baslik')->nullable();
            $table->text('aciklama_dort')->nullable();
            $table->string('aciklama_dort_baslik')->nullable();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
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
        Schema::dropIfExists('urun_detay');
    }
}
