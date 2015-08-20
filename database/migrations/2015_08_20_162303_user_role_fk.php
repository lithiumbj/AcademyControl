<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserRoleFk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('user_role', function ($table) {
        $table->integer('fk_role')->unsigned()->index()->change();
        $table->foreign('fk_role')->references('id')->on('role');
        $table->integer('fk_user')->unsigned()->index()->change();
        $table->foreign('fk_user')->references('id')->on('users');
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
