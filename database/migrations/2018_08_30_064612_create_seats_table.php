<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seats', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('show_time_id')->unsigned()->nullable();
            $table->integer('advance_booking_id')->unsigned()->nullable();
            $table->string('isAdv')->nullable();
            $table->string('ticketType');
            $table->boolean('isComp');
            $table->string('seatNumber');
            $table->boolean('hold');
            $table->boolean('status');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('show_time_id')->references('id')->on('show_times')->onDelete('cascade');
            $table->foreign('advance_booking_id')->references('id')->on('advance_bookings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seats');
    }
}
