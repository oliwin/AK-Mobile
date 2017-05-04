<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrototypeFieldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('fields_prototype', function (Blueprint $table) {
         $table->increments('id');
         $table->integer('field_id')->unsigned();
         $table->integer('prototype_id')->unsigned();
         $table->foreign('prototype_id')->references('id')->on('prototypes');
         $table->foreign('field_id')->references('id')->on('fields');
     });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fields_prototype');
    }
}
