<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('images')->insert([
            ['path' => '20201030055221dummy6.jpg', 'article_id' => 1, 'created_at' => Carbon::now()],
            ['path' => '20201030055252dummy1.jpg', 'article_id' => 1, 'created_at' => Carbon::now()],
            ['path' => '20201030055221dummy6.jpg', 'article_id' => 2, 'created_at' => Carbon::now()],
            ['path' => '20201030055221dummy6.jpg', 'article_id' => 3, 'created_at' => Carbon::now()],
            ['path' => '20201030055221dummy6.jpg', 'article_id' => 4, 'created_at' => Carbon::now()],
            ['path' => '20201030055221dummy6.jpg', 'article_id' => 5, 'created_at' => Carbon::now()],
            ['path' => '20201030055221dummy6.jpg', 'article_id' => 8, 'created_at' => Carbon::now()],

        ]);
    }
}
