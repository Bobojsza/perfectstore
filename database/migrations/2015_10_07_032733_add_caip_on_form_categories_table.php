<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCaipOnFormCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('form_categories', function(Blueprint $table)
        {
            $table->boolean('sos_tagging')->after('category')->default(0);
        });
         
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('form_categories', function(Blueprint $table)
        {
            $table->dropColumn(array('sos_tagging'));
        });
    }
}
