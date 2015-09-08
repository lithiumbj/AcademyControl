<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ClientsExtradata extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('client', function ($table) {
        $table->string('parent_name')->nullable();
        $table->string('parent_lastname_1')->nullable();
        $table->string('parent_lastname_2')->nullable();
        $table->string('parent_nif')->nullable();
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
