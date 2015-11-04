<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSecondaryDisplayOnFormGroups extends Migration
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
            $table->boolean('secondary_display')->after('group_desc')->default(0);
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
            $table->dropColumn(array('secondary_display'));
        });
    }
}
