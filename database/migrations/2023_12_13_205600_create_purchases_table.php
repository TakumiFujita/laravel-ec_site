<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            // 購入ID
            $table->bigIncrements('purchased_id');
            // 購入日時
            $table->timestamp('purchased_time');
            // 購入月
            $table->unsignedInteger('purchased_month');
            // 購入者ID
            $table->unsignedBigInteger('purchaser_id');
            // 購入合計金額
            $table->decimal('purchased_amount');
            // タイムスタンプ（created_at, updated_at）の追加
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
        Schema::dropIfExists('purchases');
    }
};
