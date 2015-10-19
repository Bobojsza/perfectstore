<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAreaIdOnStoresTable extends Migration
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
            $table->integer('account_id')->unsigned()->nullable()->after('id');
            $table->foreign('account_id')->references('id')->on('accounts');

            $table->integer('customer_id')->unsigned()->nullable()->after('account_id');
            $table->foreign('customer_id')->references('id')->on('customers');

            $table->integer('region_id')->unsigned()->nullable()->after('customer_id');
            $table->foreign('region_id')->references('id')->on('regions');

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
            $table->dropForeign('stores_account_id_foreign');
            $table->dropForeign('stores_customer_id_foreign');
            $table->dropForeign('stores_region_id_foreign');
            $table->dropColumn(array('account_id','customer_id','region_id'));
        });
    }
}
