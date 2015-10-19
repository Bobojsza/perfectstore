<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSosLookupPercentageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sos_lookup_percentages', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('sos_lookup_id')->unsigned();
            $table->foreign('sos_lookup_id')->references('id')->on('sos_lookups');
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('form_categories');
            $table->integer('sos_id')->unsigned();
            $table->foreign('sos_id')->references('id')->on('sos_taggings');
            $table->decimal('less', 5, 3);
            $table->decimal('value', 5, 3);
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
        Schema::drop('sos_lookup_percentages');
    }
}
