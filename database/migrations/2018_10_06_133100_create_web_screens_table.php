<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebScreensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('web_screens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('screen_id');
            $table->string('name');
            $table->string('totalSeats');
            $table->string('houseSeats')->nullable();
            $table->string('wheelChairSeats')->nullable();
            $table->string('image')->nullable();
            $table->text('rows');
            $table->text('columns');
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
        Schema::dropIfExists('web_screens');
    }
}
