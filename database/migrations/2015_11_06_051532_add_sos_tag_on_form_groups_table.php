<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSosTagOnFormGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('form_groups', function(Blueprint $table)
        {
            $table->integer('sos')->after('osa');
        });
         
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('form_groups', function(Blueprint $table)
        {
            $table->dropColumn(array('sos'));
        });
    }
}
