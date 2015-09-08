<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InvoiceProviderFix extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('invoice_provider', function ($table) {
            //Drop columns
            $table->dropColumn('tax');
            $table->dropColumn('tax_base');
            $table->dropColumn('total');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
    }

}
