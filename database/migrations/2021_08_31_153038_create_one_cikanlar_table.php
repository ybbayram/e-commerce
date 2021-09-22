<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOneCikanlarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('one_cikanlar', function (Blueprint $table) {
            $table->id(); 
            $table->bigInteger('dil_id')->unsigned(); 
            $table->string('baslik')->nullable(); 
            $table->string('baslik_alt')->nullable(); 
            $table->timestamps();
            $table->softDeletes(); 
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
        Schema::dropIfExists('one_cikanlar');
    }
}
