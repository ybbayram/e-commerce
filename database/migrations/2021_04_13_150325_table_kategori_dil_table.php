<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableKategoriDilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kategori_dil', function (Blueprint $table) {
            $table->id();
            $table->string('ad', 60);
            $table->bigInteger('kategori_id')->unsigned();
            $table->bigInteger('dil_id')->unsigned();
            $table->string('gorsel')->nullable();
            $table->text('aciklama');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('kategori_id')->references('id')->on('kategori')->onDelete('cascade');
            $table->foreign('dil_id')->references('id')->on('dil')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kategori_dil');
    }
}
