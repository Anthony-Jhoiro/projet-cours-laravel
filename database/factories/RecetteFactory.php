<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Recette::class, function (Faker $faker) {
    $nb = $faker->randomDigit;
    $arrPhotos = [];
    for ($i = 0; $i < $nb; $i++) {
        $arrPhotos[$i] = $faker->imageUrl ();
    }

    $nb = $faker->randomDigit;
    $arrNb = [];
    for ($i = 0; $i < $nb; $i++) {
        $arrNb[$i] = $faker->randomDigit;
    }

    
    return [
        'text' => $faker->paragraph,
        'titre' =>$faker->text (255),
        'photoUrls' => $faker->sentences($faker->randomDigit),
        'ingredients' => $faker->words($faker->randomDigit),
        'categories' => $faker->words($faker->randomDigit)

    ];
});
