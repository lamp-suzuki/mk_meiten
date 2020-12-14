<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ManagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 店舗アカウントの設定
        DB::table('manages')->insert([
            [
                'name' => 'MK名店の味',
                'domain' => 'mkmeiten',
                'email' => 'suzuki@lamp.jp',
                'email_verified_at' => date('Y-m-d H:i:s'),
                'tel' => '000-000-0000',
                'password' => Hash::make('lamp1001'),

                'delivery_flag' => 1,

                'delivery_sun' => '9:00,14:45,15:00,18:00',
                'delivery_mon' => '9:00,14:45,15:00,18:00',
                'delivery_tue' => '9:00,14:45,15:00,18:00',
                'delivery_wed' => '9:00,14:45,15:00,18:00',
                'delivery_thu' => '9:00,14:45,15:00,18:00',
                'delivery_fri' => '9:00,14:45,15:00,18:00',
                'delivery_sat' => '9:00,14:45,15:00,18:00',

                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ]);

        // 店舗の追加
        DB::table('shops')->insert([
            [
                'manages_id' => 1,
                'name' => 'WEB本店',
                'zipcode' => '000-0000',
                'pref' => '京都府',
                'address1' => 'あああ',
                'address2' => 'あああ',
                'email' => 'info@lamp.jp',
                'tel' => '000-000-0000',

                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
        ]);
    }
}
