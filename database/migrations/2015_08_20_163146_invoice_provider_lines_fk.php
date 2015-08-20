<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InvoiceProviderLinesFk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_provider_line', function ($table) {
          $table->integer('fk_provider_invoice')->unsigned()->index()->change();
          $table->foreign('fk_provider_invoice')->references('id')->on('invoice_provider');
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
