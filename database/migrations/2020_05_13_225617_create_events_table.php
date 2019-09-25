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
            $table->time('start_time');
            $table->time('end_time');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('reservable_id');
            $table->unsignedInteger('event_type_id');
            $table->unsignedBigInteger('reservation_fee');
            $table->unsignedBigInteger('security_deposit');
            $table->boolean('agree_to_terms');
            $table->boolean('esign_consent');
            $table->string('stripe_charge_id')->nullable();
            $table->string('stripe_receipt_url')->nullable();
            $table->string('reserved_from_ip_address');
            $table->timestamp('cancelled_at')->nullable();
            $table->unsignedInteger('cancelled_by_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('cancelled_by_id')->references('id')->on('users');
            $table->foreign('reservable_id')->references('id')->on('reservables');
            $table->foreign('event_type_id')->references('id')->on('event_types');

            $table->unique(['date', 'reservable_id', 'start_time', 'end_time']);
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
