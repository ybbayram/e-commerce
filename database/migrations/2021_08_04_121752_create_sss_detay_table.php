<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSssDetayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sss_detay', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sss_id')->unsigned();
            $table->string('baslik'); 
            $table->smallInteger('sira')->unsigned();
            $table->tinyInteger('durum')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('sss_id')->references('id')->on('sss')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sss_detay');
    }
}
