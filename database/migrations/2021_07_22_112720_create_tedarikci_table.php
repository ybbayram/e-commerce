<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTedarikciTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tedarikci', function (Blueprint $table) {
            $table->id();
            $table->string('ad', 100)->nullable();
            $table->string('yetkili_ad', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('telefon', 100)->nullable();
            $table->string('ulke', 100)->nullable();
            $table->string('il', 100)->nullable();
            $table->string('ilce', 100)->nullable();
            $table->text('adres')->nullable();
            $table->string('vergi_no')->nullable();
            $table->string('vergi_daire')->nullable();
            $table->text('not')->nullable();
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
        Schema::dropIfExists('tedarikci');
    }
}
