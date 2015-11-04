<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderOnAuditTemplateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audit_template_groups', function(Blueprint $table)
        {
            $table->integer('group_order')->after('id');
        });
         
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('audit_template_groups', function(Blueprint $table)
        {
            $table->dropColumn(array('group_order'));
        });
    }
}
