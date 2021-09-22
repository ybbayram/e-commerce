<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKuponKodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kupon_kod', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kupon_id')->unsigned();
            $table->string('kod')->unique();
            $table->tinyInteger('kullanim_durumu')->default('0');
            $table->timestamps();
            $table->foreign('kupon_id')->references('id')->on('kupon')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kupon_kod');
    }
}
