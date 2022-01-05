<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
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
            $table->unsignedBigInteger("user_id")->nullable();
            $table->unsignedBigInteger("product_id")->nullable();
            $table->unsignedBigInteger("package_id")->nullable();
            $table->enum('status', ['SUBMIT', 'PROCESS', 'FINISH',
                'CANCEL'])->after('invoice_number')->nullable();
            $table->float("total_price")->unsigned()->defaults(0)->nullable();
            $table->string("invoice_number")->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('orders');
    }
}
