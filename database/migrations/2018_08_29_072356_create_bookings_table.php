
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('show_time_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('ticket_id')->unsigned();
            $table->integer('movie_id')->unsigned();
            $table->integer('screen_id')->unsigned();
            $table->integer('distributer_id')->unsigned();
            $table->string('ticketType');
            $table->boolean('isComplimentary');
            $table->string('seatNumber');
            $table->integer('seatQty');
            $table->integer('price');
            $table->date('date');
            $table->date('showDate');
            $table->dateTime('showTime');
            $table->string('key');
            $table->boolean('reserveBooking');
            $table->boolean('status');
            $table->integer('cancelUserId')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('show_time_id')->references('id')->on('show_times');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('movie_id')->references('id')->on('movies');
            $table->foreign('ticket_id')->references('id')->on('tickets');
            $table->foreign('screen_id')->references('id')->on('screens');
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
        Schema::dropIfExists('bookings');
    }
}
