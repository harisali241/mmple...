<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('distributer_id')->unsigned();
            $table->foreign('distributer_id')->references('id')->on('distributers')->onDelete('cascade');
            $table->string('rating')->nullable();
            $table->date('releaseDate')->nullable();
            $table->string('genre');
            $table->integer('duration');
            $table->string('nationalCode')->nullable();
            $table->string('format')->nullable();
            $table->string('contractType')->nullable();
            $table->string('rentalCharges')->nullable();
            $table->integer('distributerSeats')->nullable();
            $table->date('contractStartDate')->nullable();
            $table->string('actor')->nullable();
            $table->text('role')->nullable();
            $table->string('poster')->nullable();
            $table->string('synopsis')->nullable();
            $table->text('trailor')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('movies');
    }
}
