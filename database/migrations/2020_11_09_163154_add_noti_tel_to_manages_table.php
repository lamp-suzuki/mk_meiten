<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotiTelToManagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('manages', function (Blueprint $table) {
            $table->string('noti_tel')->nullable();
            $table->time('noti_start_time')->nullable();
            $table->time('noti_end_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('manages', function (Blueprint $table) {
            $table->dropColumn('noti_tel');
            $table->dropColumn('noti_start_time');
            $table->dropColumn('noti_end_time');
        });
    }
}
