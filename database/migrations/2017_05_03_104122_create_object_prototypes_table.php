<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjectPrototypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('object_prototype', function (Blueprint $table) {
         $table->increments('id');
         $table->integer('prototype_id')->unsigned();
         $table->integer('object_id')->unsigned();
         $table->foreign('object_id')->references('id')->on('objects')->onDelete('cascade');
         $table->foreign('prototype_id')->references('id')->on('prototypes');
     });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('object_prototypes');
    }
}
