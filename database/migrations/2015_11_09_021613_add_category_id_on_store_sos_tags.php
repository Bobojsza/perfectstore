<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCategoryIdOnStoreSosTags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('store_sos_tags', function(Blueprint $table)
        {
            $table->integer('form_category_id')->unsigned()->nullable()->after('store_id');
            $table->foreign('form_category_id')->references('id')->on('form_categories');
        });
         
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('store_sos_tags', function(Blueprint $table)
        {
            $table->dropForeign('store_sos_tags_form_category_id_foreign');
            $table->dropColumn(array('form_category_id'));
        });
    }
}
