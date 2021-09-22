<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromosyonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promosyon', function (Blueprint $table) {
            $table->id();
            $table->string('ad');
            $table->decimal('min', 30, 2)->unsigned();
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
        Schema::dropIfExists('promosyon');
    }
}
