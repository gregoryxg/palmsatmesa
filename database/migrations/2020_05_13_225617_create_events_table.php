<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->unsignedInteger('size');
            $table->date('date');
            $table->boolean('event_approved')->default(false);
            $table->unsignedInteger('approved_by');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('reservable_id');
            $table->unsignedInteger('timeslot_id');
            $table->timestamps();

            $table->foreign('approved_by')->references('id')->on('users');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('reservable_id')->references('id')->on('reservables');
            $table->foreign('timeslot_id')->references('id')->on('timeslots');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
