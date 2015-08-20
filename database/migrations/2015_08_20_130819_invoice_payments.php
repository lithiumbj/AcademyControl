<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InvoicePayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fk_user')->index();
            $table->foreign('fk_user')->references('id')->on('user');
            $table->integer('fk_client')->index();
            $table->foreign('fk_client')->references('id')->on('client');
            $table->intger('fk_company')->index();
            $table->foreign('fk_company')->references('id')->on('company');
            $table->intger('fk_invoice')->index();
            $table->foreign('fk_invoice')->references('id')->on('invoice');
            $table->decimal('total', 5, 2)
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
