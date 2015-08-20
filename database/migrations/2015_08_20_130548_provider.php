<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Provider extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('provider', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name');
          $table->string('lastname_1');
          $table->string('lastname_2')->nullable();
          $table->string('nif');
          $table->string('address');
          $table->string('poblation')->nullable();
          $table->string('city')->nullable();
          $table->integer('phone',9)->nullable();
          $table->string('email')->nullable();
          $table->integer('fk_company')->index();
          $table->foreign('fk_company')->references('id')->on('company');
          $table->integer('cp', 5)->nullable();
          $table->longText('other_address_info')->nullable();
          $table->longText('description')->nullable();
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
