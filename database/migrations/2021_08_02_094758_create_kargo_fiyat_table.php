<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKargoFiyatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kargo_fiyat', function (Blueprint $table) {
            $table->id();              
            $table->bigInteger('ulke_id')->unsigned();
            $table->decimal('limit_alt_fiyat', 30, 2)->nullable(); 
            $table->decimal('limit_üst_fiyat', 30, 2)->nullable(); 
            $table->decimal('limit', 30, 2)->nullable(); 
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('ulke_id')->references('id')->on('ulke')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kargo_fiyat');
    }
}
