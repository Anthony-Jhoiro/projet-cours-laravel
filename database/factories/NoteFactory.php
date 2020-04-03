<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Feedback::class, function (Faker $faker) {

    return [
        'recette_id' => $faker->randomDigit,
        'note' => $faker->numberBetween(1,5),
    ];
});
