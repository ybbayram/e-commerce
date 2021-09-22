<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFiltreEtiketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filtre_etiket', function (Blueprint $table) {
         $table->id();
         $table->bigInteger('etiket_id')->unsigned();
         $table->bigInteger('filtre_id')->unsigned();
         $table->timestamps();
         $table->softDeletes();
         $table->foreign('etiket_id')->references('id')->on('etiket')->onDelete('cascade');
         $table->foreign('filtre_id')->references('id')->on('filtre')->onDelete('cascade');
     });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('filtre_etiket');
    }
}
