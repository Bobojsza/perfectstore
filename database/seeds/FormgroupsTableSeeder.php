<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class FormgroupsTableSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
		DB::table('form_groups')->truncate();

		DB::statement("INSERT INTO form_groups (id, group_desc) VALUES
			(1, 'BODY CARE'),
			(2, 'CONDITIONER'),
			(3, 'DEOS'),
			(4, 'FACE CARE'),
			(5, 'LAUNDRY'),
			(6, 'NOTES'),
			(7, 'ORAL CARE'),
			(8, 'OSA'),
			(9, 'OSA - Aspirational'),
			(10, 'OSA - Budget'),
			(11, 'OSA - FAMILY DISCOUNT'),
			(12, 'OSA - FRESH AND EASY'),
			(13, 'OSA - HYBRID'),
			(14, 'OSA - IN AND OUT'),
			(15, 'OSA - Lifestyle'),
			(16, 'OSA - MASS'),
			(17, 'OSA - PREMIUM'),
			(18, 'OSA - SMALL'),
			(19, 'OSA - SMC'),
			(20, 'OSA - SVI/SSM'),
			(21, 'OSA- Extra Small'),
			(22, 'OSA- Large'),
			(23, 'OSA- Medium'),
			(24, 'OSA- SJD'),
			(25, 'OSA-SHOPWISE'),
			(26, 'OSA-WELLCOME'),
			(27, 'PACK'),
			(28, 'PHOTOS'),
			(29, 'PLACE- SECONDARY DISPLAYS'),
			(30, 'PLACE- SHARE OF SHELVES'),
			(31, 'PLACE- SHELF STANDARD'),
			(32, 'PRODUCT'),
			(33, 'PROMO'),
			(34, 'PROPOSITION'),
			(35, 'SAVOURY'),
			(36, 'SHAMPOO'),
			(37, 'SHARE OF DISPLAY'),
			(38, 'SHELF STANDARD'),
			(39, 'STORE DETAILS'),
			(40, 'STORE VISIT DETAILS');");
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
