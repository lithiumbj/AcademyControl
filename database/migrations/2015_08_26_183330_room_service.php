<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RoomService extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_service', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('fk_user')->unsigned();
          $table->integer('fk_service')->unsigned();
          $table->integer('fk_room')->unsigned();
          $table->integer('day');
          $table->integer('hour');
          //Foreign key
          $table->foreign('fk_user')->references('id')->on('users');
          $table->foreign('fk_service')->references('id')->on('service');
          $table->foreign('fk_room')->references('id')->on('room');
          //Default timestamps
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
