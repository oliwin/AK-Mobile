<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('objects', function (Blueprint $table) {
         $table->increments('id');
         $table->string('name');
         $table->string('prefix')->nullable();
         $table->integer('visibility')->unsigned();
         $table->integer('category_id')->unsigned();
         $table->integer('available')->unsigned()->default(1);
     });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('objects');
    }
}
