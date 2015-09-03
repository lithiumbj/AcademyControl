<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Incidence extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('client_incidence', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('fk_company')->unsigned();
        $table->integer('fk_user')->unsigned();
        $table->integer('fk_client')->unsigned();
        $table->string('concept');
        $table->longText('observations');
        //Foreign key
        $table->foreign('fk_company')->references('id')->on('company');
        $table->foreign('fk_client')->references('id')->on('client');
        $table->foreign('fk_user')->references('id')->on('users');
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
