<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Tag;
use Faker\Generator as Faker;

$factory->define(Tag::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement(['総合','エンタメ','アプリ','モバイル','ファッション','ビジネス'])
    ];
});
