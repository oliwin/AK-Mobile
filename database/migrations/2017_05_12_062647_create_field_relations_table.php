<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('field_relation', function (Blueprint $table) {
         $table->integer('parent_id')->unsigned();
         $table->integer('field_id')->unsigned();
         $table->foreign('parent_id')->references('id')->on('fields')->onDelete('cascade');
         $table->foreign('field_id')->references('id')->on('fields')->onDelete('cascade');
     });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('field_relation');
    }
}
