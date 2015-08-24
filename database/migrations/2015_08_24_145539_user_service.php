<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserService extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_client', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('fk_user')->unsigned();
          $table->integer('fk_client')->unsigned();
          $table->integer('fk_service')->unsigned();
          //Foreign key
          $table->foreign('fk_user')->references('id')->on('users');
          $table->foreign('fk_client')->references('id')->on('client');
          $table->foreign('fk_service')->references('id')->on('service');
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
