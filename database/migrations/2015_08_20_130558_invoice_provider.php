<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InvoiceProvider extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_provider', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fk_provider')->index();
            $table->foreign('fk_provider')->references('id')->on('provider');
            $table->integer('fk_user')->index();
            $table->foreign('fk_user')->references('id')->on('user');
            $table->intger('fk_company')->index();
            $table->foreign('fk_company')->references('id')->on('company');
            $table->intger('status',1);
            $table->string('facnumber',12);
            $table->longText('text_public')->nullable();
            $table->longText('text_private')->nullable();
            $table->dateTime('date_creation');
            $table->dateTime('date_last_update');
            $table->decimal('tax_base', 5, 2);
            $table->decimal('tax', 5, 2);
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
