<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AssistanceAddFkRoomReserve extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('assistance', function ($table) {
        $table->integer('fk_room_reserve')->unsigned();
        //
        $table->foreign('fk_room_reserve')->references('id')->on('room_reserve');
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
