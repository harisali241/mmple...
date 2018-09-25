<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrintedTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('printed_tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('booking_id')->unsigned();
            $table->integer('show_time_id')->unsigned();
            $table->integer('movie_id')->unsigned();
            $table->integer('screen_id')->unsigned();
            $table->string('seatNumber');
            $table->integer('user_id')->unsigned();
            $table->integer('batch_id');
            $table->BigInteger('unique_id')->unique();
            $table->dateTime('showTime');
            $table->integer('price');
            $table->string('key')->nullable();
            $table->integer('cancel_user_id')->nullable()->unsigned();
            $table->boolean('status');
            $table->timestamps();

            $table->foreign('show_time_id')->references('id')->on('show_times');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('movie_id')->references('id')->on('movies');
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
            $table->foreign('screen_id')->references('id')->on('screens');
            //$table->foreign('seat_id')->references('id')->on('seats')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('printed_tickets');
    }
}
