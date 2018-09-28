<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConcessionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concession_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('concession_master_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('type');
            $table->integer('package_id')->unsigned()->nullable();
            $table->integer('item_id')->unsigned()->nullable();
            $table->integer('price')->nullable();
            $table->integer('qty')->nullable();
            $table->integer('amount')->nullable();
            $table->integer('cancelUserId')->nullable();
            $table->dateTime('cancelDate')->nullable();
            $table->boolean('status');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('package_id')->references('id')->on('packages');
            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('concession_master_id')->references('id')->on('concession_masters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('concession_details');
    }
}
