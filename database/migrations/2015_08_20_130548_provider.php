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
          $table->integer('phone')->nullable();
          $table->string('email')->nullable();
          $table->integer('fk_company');
          $table->integer('cp')->nullable();
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
