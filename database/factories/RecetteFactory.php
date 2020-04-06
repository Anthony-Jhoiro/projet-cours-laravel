<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Recette::class, function (Faker $faker) {

    return [
        'text' => $faker->paragraph,
        'titre' =>$faker->realText (255, 3)
    ];
});
