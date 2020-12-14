<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('manages_id'); // 店舗アカウント
            $table->foreign('manages_id')->references('id')->on('manages');
            $table->unsignedBigInteger('products_id'); // 商品
            $table->foreign('products_id')->references('id')->on('products');
            $table->unsignedBigInteger('orders_id'); // 注文
            $table->foreign('orders_id')->references('id')->on('orders');
            $table->string('shops_id');
            $table->integer('stock'); // 在庫カウント
            $table->date('date'); // 日付
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_customers');
    }
}
