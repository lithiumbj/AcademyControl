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
          $table->integer('fk_company')->index();
          $table->foreign('fk_company')->references('id')->on('company');
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
          $table->integer('status',2);
          //The user that register's the cliente / potential
          $table->integer('fk_user')->index();
          $table->foreign('fk_user')->references('id')->on('user');
          $table->integer('phone_parents',9)->nullable();
          $table->integer('phone_client',9)->nullable();
          $table->integer('phone_whatsapp',9)->nullable();
          $table->string('email_parents')->nullable();
          $table->string('email_client')->nullable();
          $table->integer('cp', 5)->nullable();
          $table->longText('other_address_info')->nullable();
          $table->integer('fk_contact_way')->index();
          $table->foreign('fk_contact_way')->references('id')->on('contact_way');
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
