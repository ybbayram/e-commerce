<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdresKurumsalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adres_kurumsal', function (Blueprint $table) {
           $table->id();
           $table->bigInteger('adres_id')->unsigned();
           $table->string('firma_adi');
           $table->string('vergi_numarasi');
           $table->string('vergi_dairesi');
           $table->tinyInteger('eFatura')->default(0);
           $table->timestamps();
           $table->softDeletes();
           $table->foreign('adres_id')->references('id')->on('adres')->onDelete('cascade');
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adres_kurumsal');
    }
}
