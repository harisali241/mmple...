<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebShowTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('web_show_times', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('show_time_id')->nullable();
            $table->integer('movie_id')->unsigned();
            $table->integer('screen_id')->unsigned();
            $table->integer('ticket_id')->nullable()->unsigned();
            $table->dateTime('show_dateTime');
            $table->dateTime('endDateTime');
            $table->date('show_date');
            $table->time('show_time');
            $table->string('day');
            $table->boolean('complimentrySeat');
            $table->string('key');
            $table->integer('sale')->nullable();
            $table->timestamps();

            $table->foreign('movie_id')->references('id')->on('web_movies');
            $table->foreign('screen_id')->references('id')->on('web_screens');
            $table->foreign('ticket_id')->references('id')->on('web_tickets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('web_show_times');
    }
}
