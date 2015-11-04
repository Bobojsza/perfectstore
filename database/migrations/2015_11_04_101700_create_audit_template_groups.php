<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuditTemplateGroups extends Migration
{
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_template_groups', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('audit_template_category_id')->unsigned()->nullable();
            $table->foreign('audit_template_category_id')->references('id')->on('audit_template_categories');
            $table->integer('form_group_id')->unsigned()->nullable();
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
        Schema::drop('audit_template_groups');
    }
}
