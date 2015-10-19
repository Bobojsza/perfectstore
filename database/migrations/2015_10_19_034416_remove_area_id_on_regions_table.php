<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveAreaIdOnRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('regions', function(Blueprint $table)
        {
            $table->dropForeign('regions_area_id_foreign');
            $table->dropColumn(array('area_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('regions', function(Blueprint $table)
        {
            $table->integer('area_id')->unsigned()->nullable()->after('id');
            $table->foreign('area_id')->references('id')->on('areas');
        });
    }
}
