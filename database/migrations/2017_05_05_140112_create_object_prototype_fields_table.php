<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjectPrototypeFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('object_prototype_fields', function (Blueprint $table) {
         $table->integer('object_id')->unsigned();
         $table->integer('prototype_id')->unsigned();
         $table->integer('field_id')->unsigned();
         $table->string('value');
     });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('object_prototype_fields');
    }
}
