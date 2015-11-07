<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImageOnFormsTable extends Migration
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
            $table->string('image')->after('expected_answer')->nullable();
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
            $table->dropColumn(array('image'));
        });
    }
}
