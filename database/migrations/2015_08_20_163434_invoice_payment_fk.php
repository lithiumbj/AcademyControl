<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InvoicePaymentFk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('invoice_payments', function ($table) {
        $table->integer('fk_company')->unsigned()->index()->change();
        $table->foreign('fk_company')->references('id')->on('company');
        $table->integer('fk_user')->unsigned()->index()->change();
        $table->foreign('fk_user')->references('id')->on('users');
        $table->integer('fk_client')->unsigned()->index()->change();
        $table->foreign('fk_client')->references('id')->on('client');
        $table->integer('fk_invoice')->unsigned()->index()->change();
        $table->foreign('fk_invoice')->references('id')->on('invoice');
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
