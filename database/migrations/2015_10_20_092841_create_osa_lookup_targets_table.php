<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOsaLookupTargetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('osa_lookup_targets', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('osa_lookup_id')->unsigned();
            $table->foreign('osa_lookup_id')->references('id')->on('osa_lookups');
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('form_categories');
            $table->integer('target')->unsigned();
            $table->integer('total')->unsigned();
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
        Schema::drop('osa_lookup_targets');
    }
}
