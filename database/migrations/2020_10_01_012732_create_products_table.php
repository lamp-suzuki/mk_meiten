<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('manages_id'); // 店舗アカウント
            $table->foreign('manages_id')->references('id')->on('manages');

            $table->unsignedBigInteger('categories_id'); // カテゴリ
            $table->foreign('categories_id')->references('id')->on('categories');

            $table->string('options_id')->nullable();

            $table->string('shops_id');

            $table->string('name');
            $table->integer('price');
            $table->string('unit')->default('個');
            $table->text('explanation')->nullable();
            $table->integer('stock');
            $table->integer('lead_time')->default(0);
            $table->string('status');

            $table->integer('sort_id')->default(1);

            $table->string('thumbnail_1')->nullable();
            $table->string('thumbnail_2')->nullable();
            $table->string('thumbnail_3')->nullable();

            $table->boolean('takeout_flag');
            $table->boolean('delivery_flag');
            $table->boolean('ec_flag');

            $table->dateTime('release_start')->nullable();
            $table->dateTime('release_end')->nullable();

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
        Schema::dropIfExists('products');
    }
}
