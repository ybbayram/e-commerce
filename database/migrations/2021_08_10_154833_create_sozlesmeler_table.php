<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSozlesmelerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sozlesmeler', function (Blueprint $table) {
            $table->id();
            $table->string('baslik')->nullable();
            $table->string('slug', 65)->unique();
            $table->tinyInteger('odeme_durum')->default(0);
            $table->tinyInteger('kayit_durum')->default(0);
            $table->tinyInteger('cookied_durum')->default(0);
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
        Schema::dropIfExists('sozlesmeler');
    }
}
