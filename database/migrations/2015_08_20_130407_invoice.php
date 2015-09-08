<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Invoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('invoice', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('fk_client');
          $table->integer('fk_user');
          $table->integer('fk_company');
          $table->string('facnumber',12);
          $table->integer('status');
          $table->longText('text_public')->nullable();
          $table->longText('text_private')->nullable();
          $table->dateTime('date_creation');
          $table->dateTime('date_last_update');
          $table->decimal('tax_base', 5, 2);
          $table->decimal('tax', 5, 2);
          $table->decimal('total', 5, 2);
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
