<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('measuringUnit');
            $table->integer('foodCategory_id')->unsigned();
            $table->integer('defaultPrice');
            $table->integer('costPrice');
            $table->string('image');
            $table->integer('displayOrder')->nullable();
            $table->string('bgColor')->nullable();
            $table->tinyInteger('status');
            $table->timestamps();

            $table->foreign('foodCategory_id')->references('id')->on('food_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
