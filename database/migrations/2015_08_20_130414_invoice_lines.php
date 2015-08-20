<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InvoiceLines extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_line', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fk_invoice')->index();
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
