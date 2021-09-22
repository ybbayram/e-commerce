<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCesitDetayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cesit_detay', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cesit_id')->unsigned();
            $table->string('ad');          
            $table->integer('stok')->unsigned(); 
            $table->string('kod', 50);
            $table->string('barkod')->nullable(); 
            $table->tinyInteger('durum')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('cesit_id')->references('id')->on('cesit')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cesit_detay');
    }
}
