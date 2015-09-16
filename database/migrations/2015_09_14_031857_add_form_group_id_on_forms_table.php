<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFormGroupIdOnFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('forms', function(Blueprint $table)
        {
            $table->integer('form_group_id')->unsigned()->after('id');
            $table->foreign('form_group_id')->references('id')->on('form_groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('forms', function(Blueprint $table)
        {
            $table->dropForeign('forms_form_group_id_foreign');
            $table->dropColumn(array('form_group_id'));
        });
    }
}
