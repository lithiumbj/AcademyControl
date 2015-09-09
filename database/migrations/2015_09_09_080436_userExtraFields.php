<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserExtraFields extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('users', function ($table) {
            //Add some extrafields to turn users into employee
            $table->string('address')->nullable();
            $table->integer('cp')->nullable();
            $table->string('poblation')->nullable();
            $table->string('nif')->nullable();
            $table->decimal('nomina',15,8)->nullable();
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
