<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RoomServerveAddFkRoomService extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('room_reserve', function ($table) {
        $table->dropColumn('day');
        $table->dropColumn('hour');
        $table->dropColumn('fk_room');
        $table->integer('fk_room_service')->unsigned();
        //Fk's
        $table->foreign('fk_room_service')->references('id')->on('room_service');
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
