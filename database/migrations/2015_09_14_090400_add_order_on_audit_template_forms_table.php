<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderOnAuditTemplateFormsTable extends Migration
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
            $table->integer('order')->after('id');
            $table->integer('form_category_id')->unsigned()->after('order');
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
        Schema::table('audit_template_forms', function(Blueprint $table)
        {
            $table->dropForeign('audit_template_forms_form_category_id_foreign');
            $table->dropColumn(array('order', 'form_category_id'));
        });
    }
}
