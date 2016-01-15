<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreAuditSummarysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_audit_summaries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('store_audit_id')->unsigned()->nullable();
            $table->foreign('store_audit_id')->references('id')->on('store_audits');
            $table->string('category');
            $table->string('group');
            $table->string('passed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('store_audit_summaries');
    }
}
