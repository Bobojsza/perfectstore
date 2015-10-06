<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFormGroupIdOnAuditTemplateFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audit_template_forms', function(Blueprint $table)
        {
            $table->integer('form_group_id')->unsigned()->after('form_category_id');
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
        Schema::table('audit_template_forms', function(Blueprint $table)
        {
            $table->dropForeign('audit_template_forms_form_group_id_foreign');
            $table->dropColumn(array('form_group_id'));
        });
    }
}
