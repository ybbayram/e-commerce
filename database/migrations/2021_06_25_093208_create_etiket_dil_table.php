<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEtiketDilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
     Schema::create('etiket_dil', function (Blueprint $table) {
        $table->id();
        $table->string('ad', 60);
        $table->bigInteger('etiket_id')->unsigned();
        $table->bigInteger('dil_id')->unsigned();
        $table->timestamps();
        $table->softDeletes();
        $table->foreign('etiket_id')->references('id')->on('etiket')->onDelete('cascade');
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
        Schema::dropIfExists('etiket_dil');
    }
}
