<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('movie_id')->unsigned()->nullable();
            $table->integer('show_time_id')->unsigned()->nullable();
            $table->dateTime('startDateTime')->nullable();
            $table->dateTime('endDateTime')->nullable();
            $table->text('days')->nullable();
            $table->integer('buyTicket');
            $table->text('type');
            $table->text('typeName');
            $table->text('qty');
            $table->tinyInteger('status');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('show_time_id')->references('id')->on('show_times');
            $table->foreign('movie_id')->references('id')->on('movies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deals');
    }
}
