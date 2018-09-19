<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShowTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('show_times', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('movie_id')->unsigned();
            $table->integer('screen_id')->unsigned();
            $table->integer('ticket_id')->nullable()->unsigned();
            $table->integer('voucher_id')->nullable()->unsigned();
            $table->integer('timing_id')->unsigned();
            $table->dateTime('dateTime');
            $table->dateTime('endDateTime');
            $table->date('date');
            $table->time('time');
            $table->string('day');
            $table->boolean('complimentrySeat');
            $table->string('key');
            $table->string('color');
            $table->integer('sale')->nullable();
            $table->tinyInteger('status');
            $table->timestamps();

            $table->foreign('movie_id')->references('id')->on('movies');
            $table->foreign('screen_id')->references('id')->on('screens');
            $table->foreign('timing_id')->references('id')->on('timings');
            $table->foreign('ticket_id')->references('id')->on('tickets');
            $table->foreign('voucher_id')->references('id')->on('vouchers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('show_times');
    }
}
