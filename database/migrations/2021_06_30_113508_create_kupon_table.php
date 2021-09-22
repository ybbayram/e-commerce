<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKuponTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kupon', function (Blueprint $table) {
            $table->id();
            $table->string('ad');
            $table->integer('adet');
            $table->decimal('min', 30, 2);
            $table->decimal('indirim_tutarı', 30, 2);
            $table->tinyInteger('durum')->default(0);
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
        Schema::dropIfExists('kupon');
    }
}
