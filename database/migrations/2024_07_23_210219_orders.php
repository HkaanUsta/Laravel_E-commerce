<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Orders extends Migration
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
            $table->bigInteger('card_info');
            $table->longText('product_id');
            $table->unsignedBigInteger('user_id');
            $table->string('deliver_status')->default('false')->comment('true false');
            $table->unsignedBigInteger('total');
            $table->unsignedBigInteger('price');
            $table->unsignedBigInteger('count');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
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
