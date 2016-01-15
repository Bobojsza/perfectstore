<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAccountOnStoreAuditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('store_audits', function(Blueprint $table){
            $table->string('account')->after('user_name');
            $table->string('customer_code')->after('account');
            $table->string('customer')->after('customer_code');
            $table->string('region_code')->after('customer');
            $table->string('region')->after('region_code');
            $table->string('distributor_code')->after('region');
            $table->string('distributor')->after('distributor_code');
            $table->string('template_code')->after('store_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('store_audits', function(Blueprint $table)
        {
            $table->dropColumn(array('account', 'customer_code', 'customer', 'region_code', 'region', 
                'distributor_code', 'distributor', 'template_code'));
        });
    }
}
