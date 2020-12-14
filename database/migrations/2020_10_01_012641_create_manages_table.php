<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manages', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // アカウント名
            $table->string('domain')->unique(); // ドメイン名
            $table->text('description')->nullable(); // サイト説明文
            $table->string('logo')->nullable(); // サイト説明文
            $table->string('email')->unique(); // メールアドレス
            $table->timestamp('email_verified_at')->nullable();
            $table->string('tel'); // 電話番号
            $table->string('fax')->nullable(); // fax
            $table->string('password'); // パスワード
            $table->integer('default_stock')->default(99); // 基本在庫数

            $table->unsignedBigInteger('genres_id')->default(1); // 料理ジャンル
            $table->foreign('genres_id')->references('id')->on('genres');

            $table->boolean('point_flag')->default(0); // ポイント利用

            $table->boolean('takeout_flag')->default(1); // テイクアウト提供
            $table->boolean('delivery_flag')->default(0); // デリバリー提供
            $table->boolean('ec_flag')->default(0); // 通販提供
            $table->boolean('takeout_cancel')->default(0); // テイクアウトキャンセル受付
            // デリバリー営業日
            $table->text('delivery_sun')->nullable();
            $table->text('delivery_mon')->nullable();
            $table->text('delivery_tue')->nullable();
            $table->text('delivery_wed')->nullable();
            $table->text('delivery_thu')->nullable();
            $table->text('delivery_fri')->nullable();
            $table->text('delivery_sat')->nullable();
            $table->boolean('delivery_cancel')->default(0); // デリバリーキャンセル受付
            $table->integer('delivery_shipping')->nullable(); // デリバリー送料
            $table->integer('delivery_shipping_min')->nullable(); // デリバリー最低注文金額
            $table->integer('delivery_shipping_free')->nullable(); // デリバリー送料無料設定
            $table->text('delivery_area')->nullable(); // デリバリーエリア説明文
            $table->integer('delivery_preparation')->default(60); // デリバリー提供待ち時間

            $table->boolean('ec_cancel')->default(0); // 通販キャンセル受付

            // 通販設定
            $table->string('ec_delivery_time')->nullable(); // 配送時間（改行で入力）
            $table->integer('ec_min_days')->default(3); // 最短お届日数
            $table->integer('ec_shipping')->default(0); // 通販送料
            $table->integer('ec_shipping_free')->nullable(); // 通販送料無料設定

            $table->integer('default_tax')->default(8); // デフォルト税率

            $table->boolean('alcohol_flag')->default(0); // アルコール販売

            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('instagram_url')->nullable();

            $table->boolean('show_hide')->default(1); // 表示非表示

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manages');
    }
}
