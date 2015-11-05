<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class SosTableSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
		DB::table('sos_taggings')->truncate();

		DB::statement("INSERT INTO sos_taggings (id, sos_tag) VALUES
			(1, 'CAIP'),
			(2, 'NONCAIP);");
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
