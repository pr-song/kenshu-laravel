<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Article;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'slug' => uniqid(),
        'title' => $faker->paragraph(1),
        'content' => $faker->paragraph(3),
        'thumbnail' => Str::random(10).".jpg",
        'user_id' => App\Models\User::all()->random()->id
    ];
});
