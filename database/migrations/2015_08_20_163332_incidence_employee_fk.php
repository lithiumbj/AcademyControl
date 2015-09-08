<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IncidenceEmployeeFk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('incidence_employee', function ($table) {
        $table->integer('fk_company')->unsigned()->change();
        $table->foreign('fk_company')->references('id')->on('company');
        $table->integer('fk_user_reporting')->unsigned()->change();
        $table->foreign('fk_user_reporting')->references('id')->on('users');
        $table->integer('fk_user_destiny')->unsigned()->change();
        $table->foreign('fk_user_destiny')->references('id')->on('users');
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
