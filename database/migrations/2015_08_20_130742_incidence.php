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
          Schema::create('incidence', function (Blueprint $table) {
              $table->increments('id');
              $table->integer('type');
              $table->string('title');
              $table->longText('body');
              $table->integer('fk_user')->index();
              $table->integer('fk_company')->index();
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
