<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUrunTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('urun', function (Blueprint $table) {
            $table->id();
            $table->string('baslik', 150);
            $table->string('slug', 155)->unique();
            $table->string('kod', 50)->nullable()->nullable();
            $table->string('barkod')->nullable()->nullable();
            $table->integer('stok')->unsigned()->nullable(); 
            $table->bigInteger('marka')->unsigned()->nullable(); 
            $table->tinyInteger('durum')->default(0);
            $table->tinyInteger('cesit_durum')->default(0);
            $table->tinyInteger('kontrol')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('urun');
    }
}
