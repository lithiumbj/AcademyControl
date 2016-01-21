<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LmsFile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lms_file', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('path');
            $table->string('hash');
            $table->string('type')->nullable();
            //Not really a fk
            $table->integer('fk_parent')->unsigned();
            $table->integer('fk_user')->unsigned();
            $table->integer('fk_company')->unsigned();
            //Fk's
            $table->foreign('fk_company')->references('id')->on('company');
            $table->foreign('fk_user')->references('id')->on('users');
            $table->foreign('fk_parent')->references('id')->on('lms_folder');

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
