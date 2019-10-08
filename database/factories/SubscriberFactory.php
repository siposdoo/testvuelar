<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Subscriber::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
        'sent_citat' => $faker->numberBetween(0,100),
        'email_token' => Str::random(60)

    ];
});
