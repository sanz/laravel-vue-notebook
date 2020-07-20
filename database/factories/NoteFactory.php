<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Note;
use Faker\Generator as Faker;

$factory->define(Note::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'content' => '<p>' . $faker->paragraph(20) . '</p>' . '<p>' . $faker->paragraph(20) . '</p>'
    ];
});
