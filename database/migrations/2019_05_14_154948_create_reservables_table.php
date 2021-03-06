<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservables', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description')->unique();
            $table->unsignedInteger('guest_limit');
            $table->unsignedBigInteger('reservation_fee');
            $table->unsignedBigInteger('security_deposit');
            $table->string('backgroundColor');
            $table->string('textColor');
            $table->boolean('active')->default(true);;
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
        Schema::dropIfExists('reservables');
    }
}
