<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvanceBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advance_bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('show_time_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('movie_id')->unsigned();
            $table->integer('distributer_id')->unsigned();
            $table->string('customerName');
            $table->string('customerPhone');
            $table->string('customerEmail');
            $table->string('adultPrice');
            $table->integer('adultQty')->nullable();
            $table->string('childPrice');
            $table->integer('childQty')->nullable();
            $table->integer('comQty')->nullable();
            $table->text('whichIs');
            $table->text('seatNumber');
            $table->integer('seatQty');
            $table->integer('totalAmount');
            $table->date('date');
            $table->string('key');
            $table->boolean('cancel');
            $table->boolean('status');
            $table->timestamps();

            $table->foreign('show_time_id')->references('id')->on('show_times');
            $table->foreign('movie_id')->references('id')->on('movies');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('distributer_id')->references('id')->on('distributers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advance_bookings');
    }
}
