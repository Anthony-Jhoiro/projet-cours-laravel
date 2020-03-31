<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string ('url');
            $table->unsignedBigInteger('recette_id');
            $table->enum('type', ['photo', 'video'])->default ('photo');
            $table->foreign ('recette_id')
                -> references ('id')
                -> on ('recettes')
                -> onUpdate ('cascade')
                -> onDelete ('cascade');
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
        Schema::dropIfExists('assets');
    }
}
