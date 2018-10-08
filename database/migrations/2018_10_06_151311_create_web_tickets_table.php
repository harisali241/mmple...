<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('web_tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ticket_id');
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('class')->nullable();
            $table->integer('adultPrice');
            $table->integer('childPrice')->nullable();
            $table->boolean('isChild');
            $table->string('type');
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
        Schema::dropIfExists('web_tickets');
    }
}
