<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailPlanlaEmailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_planla_email', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('mail_planla')->unsigned();
            $table->string('email', 100);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('mail_planla')->references('id')->on('mail_planla')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mail_planla_email');
    }
}
