<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Article::class, function (Faker $faker) {
    return [
        // number inside () is for characters
        'title' => $faker->text(75),
        'body' => $faker->text(200),
    ];
});
