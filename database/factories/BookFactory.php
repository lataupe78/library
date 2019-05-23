<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Author;
use App\Models\Book;

use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {

    return [
        'title' => $faker->sentence,
        'author_id' => factory(Author::class)
    ];

});
