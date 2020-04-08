<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('libelle');
            $table->timestamps ();
        });

        // Insert categories
        DB::table('categories')->insert(['libelle' => 'dessert']);
        DB::table('categories')->insert(['libelle' => 'entrée']);
        DB::table('categories')->insert(['libelle' => 'OGM']);
        DB::table('categories')->insert(['libelle' => 'plat']);
        DB::table('categories')->insert(['libelle' => 'apéro']);
        DB::table('categories')->insert(['libelle' => 'Produit à origine non-humaine']);
        DB::table('categories')->insert(['libelle' => 'Vegan friendly']);
        DB::table('categories')->insert(['libelle' => 'Gluten free']);
        DB::table('categories')->insert(['libelle' => 'Pas d\'alcool']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
