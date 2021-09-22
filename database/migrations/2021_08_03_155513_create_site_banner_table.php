<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteBannerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_banner', function (Blueprint $table) {
         $table->id();
         $table->string('ad');
         $table->smallInteger('sira')->unsigned();
         $table->tinyInteger('durum')->default(0);
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
        Schema::dropIfExists('site_banner');
    }
}
