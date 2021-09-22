<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBultenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bulten', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ziyaretci_id')->unsigned();
            $table->string('mail');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('ziyaretci_id')->references('id')->on('ziyaretci')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bulten');
    }
}
