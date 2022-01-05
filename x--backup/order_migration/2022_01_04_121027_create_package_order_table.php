<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_order', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("order_id")->nullable();
            $table->unsignedBigInteger("package_id")->nullable();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('package_order');
    }
}
