<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Recette::class, function (Faker $faker) {

    $count = $faker->randomDigitNotNull;

    $photoUrls = [];
    for ($i = 0; $i < $count; $i++) {
        $photoUrls[] = $faker->imageUrl ();
    }

    return [
        'text' => $faker->paragraph,
        'titre' =>$faker->realText (255, 3),
        'photoUrls' => $photoUrls
    ];
});
