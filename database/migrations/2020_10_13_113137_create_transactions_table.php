<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('manages_id'); // 店舗アカウント
            $table->foreign('manages_id')->references('id')->on('manages');

            $table->string('name');
            $table->string('zipcode');
            $table->string('pref');
            $table->string('address1');
            $table->string('address2');
            $table->string('tel');
            $table->text('business');
            $table->text('selling_price');
            $table->text('payment_method');
            $table->text('delivery_time');
            $table->text('returns');

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
        Schema::dropIfExists('transactions');
    }
}
