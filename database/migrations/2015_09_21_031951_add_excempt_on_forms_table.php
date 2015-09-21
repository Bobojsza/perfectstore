<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExcemptOnFormsTable extends Migration
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
            $table->boolean('expected_answer')->after('required');
            $table->boolean('exempt')->after('expected_answer');
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
            $table->dropColumn(array('expected_answer', 'exempt'));
        });
    }
}
