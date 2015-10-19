<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveRegionIdOnDistributorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('distributors', function(Blueprint $table)
        {
            $table->dropForeign('distributors_region_id_foreign');
            $table->dropColumn(array('region_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('distributors', function(Blueprint $table)
        {
            $table->integer('region_id')->unsigned()->nullable()->after('id');
            $table->foreign('region_id')->references('id')->on('regions');
        });
    }
}
