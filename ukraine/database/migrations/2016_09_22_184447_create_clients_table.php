<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('secondname');
            $table->string('patronymic');
            $table->date('datebirth');
            $table->integer('sex');
            $table->string('profession');
            $table->string('code');
            $table->string('address_office');
            $table->integer('type_work');
            $table->string('factory_name');
            $table->string('factory_edrpou');
            $table->string('factory_departament');
            $table->integer('status_pass');
            $table->integer('payment_type');
            $table->string('unique_code')->unique();
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
        Schema::drop('clients');
    }
}
