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
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->id();
            // 購入明細ID
            $table->unsignedBigInteger('purchased_detail_id');
            // 商品ID
            $table->unsignedBigInteger('item_id');
            // 購入数
            $table->unsignedInteger('purchase_number');
            // 購入ID
            $table->unsignedBigInteger('purchased_id');
            //タイムスタンプ
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
        Schema::dropIfExists('purchase_details');
    }
};
