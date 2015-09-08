<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InvoiceFk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('invoice', function ($table) {
        $table->integer('fk_company')->unsigned()->change();
        $table->foreign('fk_company')->references('id')->on('company');
        $table->integer('fk_client')->unsigned()->change();
        $table->foreign('fk_client')->references('id')->on('client');
        $table->integer('fk_user')->unsigned()->change();
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
