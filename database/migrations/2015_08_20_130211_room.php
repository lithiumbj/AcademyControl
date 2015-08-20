<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Room extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('room', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name');
          $table->string('description');
          $table->integer('capacity');
          $table->integer('fk_company')->index();
          $table->integer('is_active');
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
        //
    }
}
