<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExpectedAnswerOnTempFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('temp_forms', function(Blueprint $table)
        {
            $table->string('expected_answer')->after('choices');
        });
         
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('temp_forms', function(Blueprint $table)
        {
            $table->dropColumn(array('expected_answer'));
        });
    }
}
