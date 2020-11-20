<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->insert([
            ['name' => '総合', 'created_at' => Carbon::now()],
            ['name' => 'テクノロジー', 'created_at' => Carbon::now()],
            ['name' => 'モバイル', 'created_at' => Carbon::now()],
            ['name' => 'アプリ', 'created_at' => Carbon::now()],
            ['name' => 'エンタメ', 'created_at' => Carbon::now()],
            ['name' => 'ビューティー', 'created_at' => Carbon::now()],
            ['name' => 'ファッション', 'created_at' => Carbon::now()],
            ['name' => 'ライフスタイル', 'created_at' => Carbon::now()],
            ['name' => 'ビジネス', 'created_at' => Carbon::now()],
            ['name' => 'スポーツ', 'created_at' => Carbon::now()]
        ]);
    }
}
