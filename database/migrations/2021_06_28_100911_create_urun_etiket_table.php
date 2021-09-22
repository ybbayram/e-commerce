<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUrunEtiketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('urun_etiket', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('etiket_id')->unsigned();
            $table->bigInteger('urun_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('etiket_id')->references('id')->on('etiket')->onDelete('cascade');
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
        Schema::dropIfExists('urun_etiket');
    }
}
