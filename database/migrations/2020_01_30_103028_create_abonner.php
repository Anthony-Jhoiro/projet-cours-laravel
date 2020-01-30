<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbonner extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abonner', function (Blueprint $table) {
            $table->bigInteger('abonne');
            $table->foreign('abonne')->references('id')->on('users');
            $table->bigInteger('suivi');
            $table->foreign('suivi')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('abonner');
    }
}
