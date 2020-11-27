<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Image;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Image::class, function (Faker $faker) {
    return [
        'path' => Str::random(10).".jpg",
        'article_id' => App\Models\Article::all()->random()->id
    ];
});
