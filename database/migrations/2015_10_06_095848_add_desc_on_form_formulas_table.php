<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDescOnFormFormulasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('form_formulas', function(Blueprint $table)
        {
            $table->string('formula_desc')->after('formula');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('form_formulas', function(Blueprint $table)
        {
           $table->dropColumn(array('formula_desc'));
        });
    }
}
