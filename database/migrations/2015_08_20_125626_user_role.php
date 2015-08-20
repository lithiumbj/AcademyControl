<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('user_role', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('fk_role')->index();
          $table->foreign('fk_role')->references('id')->on('role');
          $table->integer('fk_user')->index();
          $table->foreign('fk_user')->references('id')->on('users');
          $table->timestamp('created_at');
          $table->timestamp('updated_at');
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
