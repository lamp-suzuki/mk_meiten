<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultGenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('genres')->insert([
            ['name' => '寿司'],
            ['name' => '魚料理'],
            ['name' => '和食'],
            ['name' => 'ラーメン・麺類'],
            ['name' => 'お好み焼き・粉物'],
            ['name' => '日本料理・郷土料理'],
            ['name' => 'アジア・エスニック'],
            ['name' => '中華'],
            ['name' => 'イタリアン'],
            ['name' => '洋食・西洋料理'],
            ['name' => 'フレンチ'],
            ['name' => 'アメリカ料理'],
            ['name' => '珍しい各国料理'],
            ['name' => '焼肉・ステーキ'],
            ['name' => '焼き鳥・串料理'],
            ['name' => 'しゃぶしゃぶ・すき焼き'],
            ['name' => 'カフェ・スイーツ'],
            ['name' => 'ビュッフェ・バイキング'],
            ['name' => '居酒屋・バー'],
            ['name' => 'ファミレス'],
            ['name' => 'ファストフード'],
            ['name' => 'その他'],
        ]);
    }
}
