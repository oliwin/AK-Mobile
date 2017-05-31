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
            $table->increments('id');
            $table->string('name');
            $table->string('payer');
            $table->integer('city');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('fio_manager');
            $table->string('job_position_manager');
            $table->integer('phone_manager');
            $table->integer('post_index');
            $table->string('phone');
            $table->string('address')->unique();
            $table->string('email_work')->unique();
            $table->string('bank');
            $table->string('IPN')->unique();
            $table->string('bill')->unique();
            $table->integer('region');
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
