<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InvoicePAymentFkcashflow extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('invoice_payments', function ($table) {
        $table->integer('fk_cashflow')->unsigned();
        $table->foreign('fk_cashflow')->references('id')->on('cashflow');
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
