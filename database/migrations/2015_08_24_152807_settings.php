<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Settings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('settings', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('fk_company')->unsigned();
        $table->string('clave');
        $table->string('value');
        //Foreign key
        $table->foreign('fk_company')->references('id')->on('company');
        //Default timestamps
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
