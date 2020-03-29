<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Recette::class, function (Faker $faker) {
    return [
        'text' => $faker->paragraph,
        'titre' =>$faker->text (255),
        'photoUrls' => $faker->sentences($faker->randomDigit),
        'ingredientIds' => $faker->words($faker->randomDigit),
        'categories' => $faker->words($faker->randomDigit)

    ];
});
