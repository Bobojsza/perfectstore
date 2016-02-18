<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCustomOnFormCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('form_categories', function(Blueprint $table){
            $table->integer('custom')->after('osa_tagging');
            $table->integer('perfect_store')->after('custom');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('form_categories', function(Blueprint $table){
             $table->dropColumn(array('custom', 'perfect_store'));
        });
    }
}
