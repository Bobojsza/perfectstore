<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGradeMatrixIdOnStoresTable extends Migration
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
            $table->integer('grade_matrix_id')->unsigned()->nullable()->after('store');
            $table->foreign('grade_matrix_id')->references('id')->on('grade_matrixs');
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
            $table->dropForeign('stores_grade_matrix_id_foreign');
            $table->dropColumn(array('grade_matrix_id'));
        });
    }
}
