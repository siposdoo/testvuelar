<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Article::class, function (Faker $faker) {
    return [
        'naziv' => $faker->text(30),
        'text' => $faker->text(500)

    ];
});
