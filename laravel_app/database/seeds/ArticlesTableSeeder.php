<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('articles')->insert([
            ['slug' => uniqid(), 
                'title' => '送金アプリ「pring」、オリコと法人送金サービスで業務提携', 
                'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 
                'thumbnail' => '20201030055221dummy6.jpg',
                'user_id' => 1, 
                'created_at' => Carbon::now()
            ],
            ['slug' => uniqid(), 
                'title' => 'アドベンチャーゲーム『Metamorphosis(メタモルフォーシス)』がPS4とNintendo Switchで発売！', 
                'content' => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.', 
                'thumbnail' => null,
                'user_id' => 2, 
                'created_at' => Carbon::now()
            ],
            ['slug' => uniqid(), 
                'title' => '★キャンプにおすすめ！★暗闇専用ボードゲーム『キャンパー＆ダンジョン』の先行予約を開始しました', 
                'content' => 'Contrary to popular belief, Lorem Ipsum is not simply random text.', 
                'thumbnail' => '20201030055221dummy6.jpg',
                'user_id' => 3, 
                'created_at' => Carbon::now()
            ],
            ['slug' => uniqid(), 
                'title' => 'ハッシュタグの数だけレゴが寄付される「#ハッピークリスマスをつなげよう #BuildtoGive」スタート', 
                'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 
                'thumbnail' => '20201030055221dummy6.jpg',
                'user_id' => 1, 
                'created_at' => Carbon::now()
            ],
            ['slug' => uniqid(), 
                'title' => '「靴下屋×OSAMU GOODS」コラボソックス　待望の第2弾発売！！', 
                'content' => 'The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested.',
                'thumbnail' => null, 
                'user_id' => 4, 
                'created_at' => Carbon::now()
            ],
            ['slug' => uniqid(), 
                'title' => 'コロナ禍で〝はたらくヒトを応援するマスク〟「BIZ MASK」シリーズ新発売！', 
                'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 
                'thumbnail' => null,
                'user_id' => 2, 
                'created_at' => Carbon::now()
            ],
            ['slug' => uniqid(), 
                'title' => 'Google Recommendations AI をイオングループ の ブランシェス株式会社が導入', 
                'content' => 'It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.', 
                'thumbnail' => null,
                'user_id' => 4, 
                'created_at' => Carbon::now()
            ],
            ['slug' => uniqid(), 
                'title' => 'ブランドバッグシェア「ラクサス」が日本最大級の駅ビル「LUCUA」でバッグがその場で持って帰れるPOPUPストアを開催', 
                'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 
                'thumbnail' => '20201030055221dummy6.jpg',
                'user_id' => 1, 
                'created_at' => Carbon::now()
            ]
        ]);
    }
}
