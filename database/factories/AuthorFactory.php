<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Author;
use Faker\Generator as Faker;

$factory->define(Author::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'birth_date' => $faker->dateTimeBetween('-80 years'),
    ];
});
