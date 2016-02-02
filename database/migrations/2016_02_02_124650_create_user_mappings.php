<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserMappings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_mappings', function(Blueprint $table){
            $table->increments('id');
            $table->string('user_name');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('mapped_stores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_mappings');
    }
}
