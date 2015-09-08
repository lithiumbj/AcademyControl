<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Client extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('client', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('fk_company');
          $table->string('name');
          $table->string('lastname_1');
          $table->string('lastname_2')->nullable();
          $table->string('nif')->nullable();
          $table->string('address');
          $table->string('poblation')->nullable();
          $table->string('city')->nullable();
          //The status of the client
          /*
           * 0 = Potential, not client yet
           * 1 = Client
           * 2 = Ex-client
           */
          $table->integer('status');
          //The user that register's the cliente / potential
          $table->integer('fk_user')->index();
          $table->integer('phone_parents')->nullable();
          $table->integer('phone_client')->nullable();
          $table->integer('phone_whatsapp')->nullable();
          $table->string('email_parents')->nullable();
          $table->string('email_client')->nullable();
          $table->integer('cp')->nullable();
          $table->longText('other_address_info')->nullable();
          $table->integer('fk_contact_way')->index();
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
