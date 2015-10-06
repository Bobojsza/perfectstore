<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTemplateIdOnFormsTable extends Migration
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
            $table->dropForeign('forms_form_group_id_foreign');
            $table->dropColumn(array('form_group_id'));

            $table->integer('audit_template_id')->unsigned()->after('id');
            $table->foreign('audit_template_id')->references('id')->on('audit_templates');
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
            $table->integer('form_group_id')->unsigned()->after('id');
            $table->foreign('form_group_id')->references('id')->on('form_groups');

            $table->dropForeign('forms_audit_template_id_foreign');
            $table->dropColumn(array('audit_template_id'));
        });
    }
}
