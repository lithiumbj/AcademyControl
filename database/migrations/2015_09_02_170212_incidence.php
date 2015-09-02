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
