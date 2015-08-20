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
          $table->integer('fk_client');
          $table->integer('fk_room');
          $table->integer('fk_user');
          $table->integer('fk_company');
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
