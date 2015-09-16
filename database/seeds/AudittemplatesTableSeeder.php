<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class AudittemplatesTableSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
		DB::table('audit_templates')->truncate();

		DB::statement("INSERT INTO audit_templates (id, template) VALUES
			(1, 'DT DS'),
			(2, 'DT MAG - Hybrid'),
			(3, 'DT MAG - Mass'),
			(4, 'DT MAG - Premium'),
			(5, 'DT MAG - Small'),
			(6, 'DT PM Gulayan'),
			(7, 'DT PM Reseller'),
			(8, 'DT PM Retailer'),
			(9, 'DT SSS Big'),
			(10, 'DT SSS Small'),
			(11, 'MT BIG 10 L'),
			(12, 'MT BIG 10 M'),
			(13, 'MT BIG 10 S'),
			(14, 'MT Mass Dept'),
			(15, 'MT MDC L'),
			(16, 'MT MDC M'),
			(17, 'MT MDC S'),
			(18, 'MT MDC XS'),
			(19, 'MT Premium Dept'),
			(20, 'MT Puregold Aspirational'),
			(21, 'MT Puregold Budget'),
			(22, 'MT Puregold Lifestyle'),
			(23, 'MT RSC Family Discount'),
			(24, 'MT RSC Fresh and Easy'),
			(25, 'MT RSC In and Out'),
			(26, 'MT Rustans L'),
			(27, 'MT Rustans M'),
			(28, 'MT Rustans S'),
			(29, 'MT Shopwise'),
			(30, 'MT SJD'),
			(31, 'MT SMC'),
			(32, 'MT SSM'),
			(33, 'MT SVI'),
			(34, 'MT Waltermart'),
			(35, 'MT Watsons'),
			(36, 'MT Wellcome');");
		
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
