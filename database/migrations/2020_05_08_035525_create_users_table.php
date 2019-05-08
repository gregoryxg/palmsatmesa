<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->unsignedInteger('unit_id');
            $table->unsignedInteger('resident_status_id');
            $table->boolean('account_approved')->default(false);
            $table->boolean('administrator')->default(false);
            $table->boolean('active')->default(true);
            $table->unsignedInteger('gate_code');
            $table->string('mobile_phone');
            $table->string('home_phone')->nullable();
            $table->string('work_phone')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->timestamp('last_login_at')->nullable();
            $table->timestamp('password_expires_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();

            $table->foreign('unit_id')->references('id')->on('units');
            $table->foreign('resident_status_id')->references('id')->on('resident_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
