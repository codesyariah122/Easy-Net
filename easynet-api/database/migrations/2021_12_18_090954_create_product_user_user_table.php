<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductUserUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_user_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_user_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            // $table->unsignedBigInteger('user_product_id')->nullable/();
            $table->foreign('product_user_id')->references('id')->on('product_users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('user_id')->on('product_users')->onDelete('cascade')->onUpdate('cascade');
            // $table->foreign('user_product_id')->references('product_id')->on('product_users');
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
        Schema::dropIfExists('product_user_user');
    }
}
