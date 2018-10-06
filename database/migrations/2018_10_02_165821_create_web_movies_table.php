<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('web_movies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('movie_id');
            $table->string('rating')->nullable();
            $table->date('releaseDate')->nullable();
            $table->string('genre');
            $table->integer('duration');
            $table->string('actor')->nullable();
            $table->text('role')->nullable();
            $table->string('poster')->nullable();
            $table->string('synopsis')->nullable();
            $table->text('trailor')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    // public function down()
    // {
    //     Schema::dropIfExists('web_movies');
    // }
}
