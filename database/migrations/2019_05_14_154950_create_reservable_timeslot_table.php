<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservableTimeslotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservable_timeslot', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('reservable_id');
            $table->unsignedInteger('timeslot_id');
            $table->timestamps();

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
        Schema::dropIfExists('reservable_timeslot');
    }
}
