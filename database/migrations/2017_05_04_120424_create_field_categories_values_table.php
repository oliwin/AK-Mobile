<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldCategoriesValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('field_categories_values', function (Blueprint $table) {
         $table->integer('category_id')->unsigned();
         $table->integer('object_id')->unsigned();
         $table->foreign('object_id')->references('id')->on('objects')->onDelete('objects');
         $table->foreign('category_id')->references('id')->on('field_categories')->onDelete('field_categories');
     });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('field_categories_values');
    }
}
