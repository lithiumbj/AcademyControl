<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IncidenceEmployee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::create('incidence_employee', function (Blueprint $table) {
              $table->increments('id');
              $table->integer('type');
              $table->string('title');
              $table->longText('body');
              $table->integer('fk_user_reporting');
              $table->integer('fk_user_destiny');
              $table->integer('fk_company');
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
