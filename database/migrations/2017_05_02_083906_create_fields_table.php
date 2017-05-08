<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrototypeFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('fields', function (Blueprint $table) {
         $table->increments('id');
         $table->string('name');
         $table->string('prefix');
         $table->boolean('only_numbers')->nullable();
         $table->integer('available')->unsigned()->default(1);
         $table->integer('visibility')->unsigned();
     });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fields');
    }
}
