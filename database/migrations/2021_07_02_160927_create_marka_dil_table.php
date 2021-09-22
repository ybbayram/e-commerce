<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarkaDilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marka_dil', function (Blueprint $table) {
            $table->id(); 
            $table->bigInteger('marka_id')->unsigned();
            $table->bigInteger('dil_id')->unsigned();
            $table->string('gorsel')->nullable();
            $table->string('logo')->nullable();
            $table->text('aciklama')->nullable();;
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('marka_id')->references('id')->on('marka')->onDelete('cascade');
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
        Schema::dropIfExists('marka_dil');
    }
}
