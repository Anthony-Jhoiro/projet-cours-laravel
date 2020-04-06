<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Assets::class, function (Faker $faker) {
    \Illuminate\Support\Facades\Log::debug ($faker->imageUrl ());
    return [
        'url' => $faker->imageUrl ()
    ];
});
