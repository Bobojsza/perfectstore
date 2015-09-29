<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTemplateIdOnStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stores', function(Blueprint $table)
        {
            $table->integer('audit_template_id')->unsigned()->nullable()->after('store');
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
        Schema::table('stores', function(Blueprint $table)
        {
            $table->dropForeign('stores_audit_template_id_foreign');
            $table->dropColumn(array('audit_template_id',));
        });
    }
}
