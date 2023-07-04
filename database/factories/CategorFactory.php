<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Categor;
use Faker\Generator as Faker;

$factory->define(Categor::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'slug' => $faker->slug(6)
    ];
});
