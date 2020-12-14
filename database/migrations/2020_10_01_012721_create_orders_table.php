<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('manages_id'); // 店舗アカウント
            $table->foreign('manages_id')->references('id')->on('manages');

            $table->unsignedBigInteger('shops_id'); // 店舗
            $table->foreign('shops_id')->references('id')->on('shops');

            $table->json('carts');
            $table->string('service');
            $table->string('delivery_time');
            $table->integer('shipping');
            $table->integer('okimochi');
            $table->integer('total_amount');
            $table->string('payment_method');

            $table->string('pay_tok')->nullable(); // PAY.JPからクレジットトークン
            $table->string('charge_id')->nullable(); // PAY.JPからのチャージID

            $table->unsignedBigInteger('users_id')->nullable();

            $table->string('name');
            $table->string('furigana');
            $table->string('email');
            $table->string('tel');
            $table->string('zipcode')->nullable();
            $table->string('pref')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('memo')->nullable();

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
        Schema::dropIfExists('orders');
    }
}
