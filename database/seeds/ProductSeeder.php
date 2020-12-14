<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // カテゴリーの追加
        DB::table('categories')->insert([
            [
                'manages_id' => 1,
                'name' => 'ケーキ（アントルメ）',
                'sort_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
        ]);

        // オプションの追加
        DB::table('options')->insert([
            [
                'categories_id' => 1,
                'name' => 'ろうそく',
                'price' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'categories_id' => 1,
                'name' => 'ﾊﾞｰｽﾃﾞｰﾌﾟﾚｰﾄ(お誕生日おめでとう＋お名前)',
                'price' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'categories_id' => 1,
                'name' => 'ﾊﾞｰｽﾃﾞｰﾌﾟﾚｰﾄ(HappyBirthday＋お名前)',
                'price' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
        ]);

        // 商品の追加
        DB::table('products')->insert([
            [
                'manages_id' => 1,
                'categories_id' => 1,
                'options_id' => '1,2,3,',
                'shops_id' => '1,',
                'name' => 'ムッシュ・モンブラン（長さ12cm）',
                'price' => 1200,
                'unit' => '個',
                'explanation' => 'マールブランシュのスペシャリテ、モンブラン。ラム酒を香らせたマロンクリームで、きざみ栗と生クリーム、スポンジケーキを包みました。（長さ12cm）※12/21〜25の期間は販売休止いたします。',
                'stock' => 99,
                'lead_time' => 120,
                'status' => 'public',
                'thumbnail_1' => '/images/c1item_1.jpeg',
                'takeout_flag' => 0,
                'delivery_flag' => 1,
                'ec_flag' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'manages_id' => 1,
                'categories_id' => 1,
                'options_id' => '1,2,3,',
                'shops_id' => '1,',
                'name' => 'べリーハッピープレゼント（直径約12cm）',
                'price' => 3000,
                'unit' => '個',
                'explanation' => 'ピンク色の苺クリームで可愛くラッピング！ハチミツ入りのスポンジケーキで、たっぷりの苺と口溶けのよい生クリームをサンドしました。※12/21〜25のクリスマス期間は、製造を一時休止いたします。',
                'stock' => 99,
                'lead_time' => 120,
                'status' => 'public',
                'thumbnail_1' => '/images/c1item_2.jpeg',
                'takeout_flag' => 0,
                'delivery_flag' => 1,
                'ec_flag' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'manages_id' => 1,
                'categories_id' => 1,
                'options_id' => '1,2,3,',
                'shops_id' => '1,',
                'name' => 'モンブランロワイヤル（直径約12cm）',
                'price' => 3000,
                'unit' => '個',
                'explanation' => '1982年創業からのスペシャリテ「モンブラン」をアニバーサリーにもぜひ。ラム酒香るマロンクリームで、きざみ栗と生クリーム、スポンジケーキを包み、香り豊かなシロップ漬けの栗を飾りました。',
                'stock' => 99,
                'lead_time' => 120,
                'status' => 'public',
                'thumbnail_1' => '/images/c1item_7.jpeg',
                'takeout_flag' => 0,
                'delivery_flag' => 1,
                'ec_flag' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'manages_id' => 1,
                'categories_id' => 1,
                'options_id' => '1,2,3,',
                'shops_id' => '1,',
                'name' => '京都産シャインマスカットのショートケーキ',
                'price' => 1850,
                'unit' => '個',
                'explanation' => '京丹後市「白岩農園〜うみのみえる丘〜」で海風を浴び、 香りよく、小粒でぎゅっと濃ゆく実ったシャインマスカットを贅沢に使用し、フロマージュブランクリームでショートケーキ仕立てに。',
                'stock' => 99,
                'lead_time' => 120,
                'status' => 'public',
                'thumbnail_1' => '/images/c1item_9.jpeg',
                'takeout_flag' => 0,
                'delivery_flag' => 1,
                'ec_flag' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
        ]);
    }
}
