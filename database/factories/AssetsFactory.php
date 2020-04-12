<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Assets;
use Faker\Generator as Faker;

$factory->define( Assets::class, function ( Faker $faker) {
    return [
        'url' => $faker->imageUrl ()
    ];
});
