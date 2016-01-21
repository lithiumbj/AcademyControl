<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LmsFolderToClient extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lms_folder_to_client', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fk_client')->unsigned();
            $table->integer('fk_folder')->unsigned();
            //Fk's
            $table->foreign('fk_client')->references('id')->on('client');
            $table->foreign('fk_folder')->references('id')->on('lms_folder');

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
