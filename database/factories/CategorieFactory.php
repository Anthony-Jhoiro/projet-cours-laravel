<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Categorie::class, function (Faker $faker) {
    return [
        'libelle' => $faker->word
    ];
});
