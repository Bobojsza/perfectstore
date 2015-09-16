<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class FormcategoriesTableSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
		DB::table('form_categories')->truncate();

		DB::statement("INSERT INTO form_categories (id, category) VALUES
			(1, 'CONDITIONER'),
			(2, 'DEOS'),
			(3, 'FABCON'),
			(4, 'FACE CARE'),
			(5, 'HAIR CARE'),
			(6, 'LAUNDRY'),
			(7, 'MEN'),
			(8, 'NOTES'),
			(9, 'ORAL CARE'),
			(10, 'OTHERS'),
			(11, 'PACK'),
			(12, 'PLACE- Share of Shelves'),
			(13, 'PLACE- Shelf Standard'),
			(14, 'PRODUCT'),
			(15, 'PROMO'),
			(16, 'SAVOURY'),
			(17, 'SHAMPOO'),
			(18, 'STORE INFORMATION');");
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
