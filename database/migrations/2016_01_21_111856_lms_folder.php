<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LmsFolder extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('lms_folder', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            //Not really a fk
            $table->integer('fk_parent')->nullable();
            $table->integer('fk_user')->unsigned();
            $table->integer('fk_company')->unsigned();
            $table->integer('can_see_others')->unsigned();
            $table->integer('can_view_others')->unsigned();
            $table->integer('can_write_others')->unsigned();
            //Fk's
            $table->foreign('fk_company')->references('id')->on('company');
            $table->foreign('fk_user')->references('id')->on('users');

            //Default timestamps
            $table->timestamps();
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
