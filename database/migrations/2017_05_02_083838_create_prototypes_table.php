<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrototypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('prototypes', function (Blueprint $table) {
         $table->increments('id');
         $table->string('name');
         $table->string('prefix');
         $table->integer('type')->unsigned()->default(1);
         $table->integer('visibility')->unsigned();
         $table->string('default');
         $table->string('value')->nullable();
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
        Schema::dropIfExists('prototypes');
    }
}
