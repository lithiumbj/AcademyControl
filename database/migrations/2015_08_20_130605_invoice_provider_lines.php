<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InvoiceProviderLines extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::create('invoice_provider_line', function (Blueprint $table) {
              $table->increments('id');
              $table->integer('fk_provider_invoice')->index();
              $table->foreign('fk_provider_invoice')->references('id')->on('invoice_provider');
              $table->integer('fk_service')->index();
              $table->string('prod_name');
              $table->string('prod_description');
              $table->decimal('tax_base', 5, 2);
              $table->decimal('tax', 5, 2);
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
