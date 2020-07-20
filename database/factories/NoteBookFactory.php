<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\NoteBook;
use Faker\Generator as Faker;

$factory->define(NoteBook::class, function (Faker $faker) {
    return [
        'title' => $faker->name
    ];
});
