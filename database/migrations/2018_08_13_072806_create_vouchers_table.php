<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('price');
            $table->date('startDate');
            $table->date('endDate');
            $table->boolean('isPackage')->nullable();
            $table->text('itemName')->nullable();
            $table->text('itemPrice')->nullable();
            $table->text('itemQty')->nullable();
            $table->text('ticketType')->nullable();
            $table->text('ticketName')->nullable();
            $table->text('ticketPrice')->nullable();
            $table->text('ticketQty')->nullable();
            $table->tinyInteger('status');
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
        Schema::dropIfExists('vouchers');
    }
}
