<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailGruplariTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_gruplari', function (Blueprint $table) {
            $table->id();
            $table->string('ad', 60);
            $table->tinyInteger('grup')->unsigned();
            $table->timestamp('baslangic_tarihi')->nullable();
            $table->timestamp('bitis_tarihi')->nullable();
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
        Schema::dropIfExists('mail_gruplari');
    }
}
