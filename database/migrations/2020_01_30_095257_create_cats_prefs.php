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
            $table->bigInteger('user_id')->unsigned ();
            $table->bigInteger('categorie_id')->unsigned ();
            $table->dateTime('derniere_visite');
            $table->integer('nb_visite');
            $table->foreign('categorie_id')
                ->references('id')
                ->on('categories')
                ->onUpdate('cascade')
                ->onDelete('restrict');


            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('restrict');
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
