<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecetteCategorieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recette_categorie', function (Blueprint $table) {
            //$table->bigIncrements('id');+
            $table->unsignedBigInteger ('id_categorie');
            $table->unsignedBigInteger ('id_recette');

            $table->foreign ('id_categorie')
                ->references ('id')
                ->on ('categories')
                ->onUpdate ('cascade')
                ->onDelete ('cascade');

            $table->foreign ('id_recette')
                ->references ('id')
                ->on ('recettes')
                ->onUpdate ('cascade')
                ->onDelete ('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recette_categorie');
    }
}
