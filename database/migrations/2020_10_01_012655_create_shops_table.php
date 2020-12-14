<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('manages_id'); // 店舗アカウント
            $table->foreign('manages_id')->references('id')->on('manages');

            $table->string('name'); // 店舗名
            $table->string('zipcode'); // 郵便番号
            $table->string('pref'); // 都道府県
            $table->string('address1'); // 住所1
            $table->string('address2'); // 住所2
            $table->string('email'); // メールアドレス
            $table->string('tel'); // 電話番号
            $table->string('fax')->nullable(); // fax
            $table->string('access')->nullable(); // アクセス
            $table->string('googlemap_url')->nullable(); // GoogleMap
            $table->string('parking')->nullable(); // 駐車場
            $table->text('holiday')->nullable(); // 休業日
            $table->string('payment')->default('1,');
            $table->string('payment_type')->nullable(); // 現地決済の種類
            // テイクアウト営業日
            $table->string('takeout_sun')->nullable();
            $table->string('takeout_mon')->nullable();
            $table->string('takeout_tue')->nullable();
            $table->string('takeout_wed')->nullable();
            $table->string('takeout_thu')->nullable();
            $table->string('takeout_fri')->nullable();
            $table->string('takeout_sat')->nullable();

            $table->integer('takeout_preparation')->default(30); // テイクアウト提供待ち時間

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
        Schema::dropIfExists('shops');
    }
}
