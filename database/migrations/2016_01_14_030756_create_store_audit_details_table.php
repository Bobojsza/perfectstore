<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreAuditDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_audit_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('store_audit_id')->unsigned()->nullable();
            $table->foreign('store_audit_id')->references('id')->on('store_audits');
            $table->string('category');
            $table->string('group');
            $table->string('prompt');
            $table->string('type');
            $table->string('answer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('store_audit_details');
    }
}
