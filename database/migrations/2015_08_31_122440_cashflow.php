<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Cashflow extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('cashflow', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('fk_company')->unsigned();
        $table->integer('fk_user')->unsigned();
        $table->string('concept');
        $table->decimal('value');
        //Foreign key
        $table->foreign('fk_company')->references('id')->on('company');
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
