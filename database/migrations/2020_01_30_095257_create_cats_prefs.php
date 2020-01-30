<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatsPrefs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cats_prefs', function (Blueprint $table) {
            $table->bigInteger('users_id');
            $table->foreign('users_id')->references('id')->on('users');
            $table->bigInteger('categories_id');
            $table->foreign('categories_id')->references('id')->on('categories');
            $table->dateTime('derniere_visite');
            $table->integer('nb_visite');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cats_prefs');
    }
}
