<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOsaTaggingOnFormCategoriesTable extends Migration
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
            $table->boolean('osa_tagging')->after('secondary_display')->default(0);
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
            $table->dropColumn(array('osa_tagging'));
        });
    }
}
