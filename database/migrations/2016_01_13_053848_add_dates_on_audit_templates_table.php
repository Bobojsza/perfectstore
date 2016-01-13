<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDatesOnAuditTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audit_templates', function(Blueprint $table)
        {
            $table->date('start_date')->after('template');
            $table->date('end_date')->after('start_date');
        });
         
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('audit_templates', function(Blueprint $table)
        {
            $table->dropColumn(array('start_date', 'end_date'));
        });
    }
}
