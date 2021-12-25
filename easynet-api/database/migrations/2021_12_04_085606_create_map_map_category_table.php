<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMapMapCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('map_map_category', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('map_id')->nullable();
            $table->unsignedBigInteger('map_category_id')->nullable();
            $table->foreign('map_id')->references('id')->on('maps');
            $table->foreign('map_category_id')->references('id')->on('map_categories');
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
        Schema::dropIfExists('map_map_category');
    }
}
