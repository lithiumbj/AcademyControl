<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RoomReserve extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('room_reserve', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('fk_client')->index();
          $table->foreign('fk_client')->references('id')->on('client');
          $table->integer('fk_room')->index();
          $table->foreign('fk_room')->references('id')->on('room');
          $table->integer('fk_user')->index();
          $table->foreign('fk_user')->references('id')->on('user');
          $table->intger('fk_company')->index();
          $table->foreign('fk_company')->references('id')->on('company');
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
