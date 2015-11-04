<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

use App\Store;
use App\SecondaryDisplayLookup;

class UploadSecondaryDisplayLookupTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		DB::table('secondary_display_lookups')->truncate();

		$reader = ReaderFactory::create(Type::XLSX); // for XLSX files
		$filePath = 'database/seeds/seed_files/Secondary Display.xlsx';
		$reader->open($filePath);

	   // Accessing the sheet name when reading
		foreach ($reader->getSheetIterator() as $sheet) {
			if($sheet->getName() == 'Sheet1'){
				$cnt = 0;
				foreach ($sheet->getRowIterator() as $row) {
					if($cnt > 2){
						$store = Store::where('store_code',trim($row[1]))->first();
						$brands = array();
						if(!empty($store)){
							$x = 1;
							for ($i=3; $i < 28; $i++) { 
								if($row[$i] == "1.0"){
									$brands[] = $x;
								}
								$x++;
							}
							foreach ($brands as $value) {
								SecondaryDisplayLookup::create(['store_id' => $store->id, 'secondary_display_id' => $value]);
							}
						}
						
					}
					
					$cnt++;
				}
			}else{

			}
		}

		$reader->close();

		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
		Model::reguard();
    }
}
