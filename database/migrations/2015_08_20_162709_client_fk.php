<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ClientFk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client', function ($table) {
          $table->integer('fk_company')->unsigned()->index()->change();
          $table->foreign('fk_company')->references('id')->on('company');
          $table->integer('fk_contact_way')->unsigned()->index()->change();
          $table->foreign('fk_contact_way')->references('id')->on('contact_way');
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
