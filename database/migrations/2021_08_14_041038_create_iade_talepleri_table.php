<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIadeTalepleriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iade_talepleri', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('siparis_id')->unsigned();
            $table->string('iade_sebebi')->nullable();
            $table->string('aciklama')->nullable();
            $table->string('gorsel')->nullable();
            $table->string('gorsel2')->nullable();
            $table->tinyInteger('durum')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('siparis_id')->references('id')->on('siparis')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('iade_talepleri');
    }
}
