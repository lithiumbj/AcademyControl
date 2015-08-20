<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserRolePermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('user_role_permission', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('fk_role')->index();
          $table->foreign('fk_role')->references('id')->on('role');
          $table->string('perm');
          $table->integer('allowed');
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
