<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderOrderUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_order_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_user_id')->nullable();
            $table->unsignedBigInteger('order_id')->nullable();
            
            $table->foreign('order_user_id')->references('user_id')->on('order_users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('order_id')->references('id')->on('order_users')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('order_order_user');
    }
}
