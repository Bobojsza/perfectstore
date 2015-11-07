<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeExpectedAnswerOnFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `forms` CHANGE `expected_answer` `expected_answer` VARCHAR(255)  NOT NULL  DEFAULT '';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE `forms` CHANGE `expected_answer` `expected_answer` TINYINT(1)  NOT NULL;");
    }
}
