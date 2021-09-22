<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adres', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ziyaretci_id')->unsigned();
            $table->string('baslik', 50);
            $table->string('isim', 50);
            $table->string('mail', 100);
            $table->string('telefon', 30);
            $table->string('kimlik_no', 50)->nullable();
            $table->string('ulke', 50);
            $table->string('il', 50);
            $table->string('ilce', 50);
            $table->string('mahalle', 50);
            $table->string('adres', 500);
            $table->string('postakodu', 30)->nullable();
            $table->tinyInteger('durum')->default(1);
            $table->tinyInteger('kurumsal_mi')->default(0);
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
        Schema::dropIfExists('adres');
    }
}
