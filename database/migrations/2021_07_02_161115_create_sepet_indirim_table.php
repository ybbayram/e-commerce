<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSepetIndirimTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sepet_indirim', function (Blueprint $table) {
            $table->id();
            $table->string('ad');
            $table->decimal('min', 30, 2);
            $table->tinyInteger('tur')->unsigned();
            $table->decimal('indirim_oranı', 30, 2)->unsigned();
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
        Schema::dropIfExists('sepet_indirim');
    }
}
