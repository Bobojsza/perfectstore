<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCategoryOnAuditTemplateFormsTable extends Migration
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
            $table->dropForeign('audit_template_forms_form_category_id_foreign');
            $table->dropForeign('audit_template_forms_form_group_id_foreign');
            $table->dropColumn(array('category_order','group_order','form_category_id', 'form_group_id'));

            $table->integer('audit_template_group_id')->unsigned()->nullable()->after('id');
            $table->foreign('audit_template_group_id')->references('id')->on('audit_template_groups');

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
            $table->dropForeign('audit_template_forms_audit_template_group_id_foreign');
            $table->dropColumn(array('audit_template_group_id'));

            $table->integer('category_order')->after('id');
            $table->integer('group_order')->after('id');

            $table->integer('form_category_id')->unsigned()->nullable()->after('order');
            $table->foreign('form_category_id')->references('id')->on('form_categories');

            $table->integer('form_group_id')->unsigned()->nullable()->after('form_category_id');
            $table->foreign('form_group_id')->references('id')->on('form_groups');
        });
    }
}
