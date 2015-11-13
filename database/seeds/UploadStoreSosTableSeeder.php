<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Store;
use App\FormCategory;
use App\SosTagging;
use App\StoreSosTag;

use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

class UploadStoreSosTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		DB::table('store_sos_tags')->truncate();

		$reader = ReaderFactory::create(Type::XLSX); // for XLSX files
		$filePath = 'database/seeds/seed_files/Store SOS.xlsx';
		$reader->open($filePath);

	   // Accessing the sheet name when reading
		foreach ($reader->getSheetIterator() as $sheet) {
			if($sheet->getName() == 'Sheet1'){
				$cnt = 0;
				foreach ($sheet->getRowIterator() as $row) {
					if(!is_null($row[0])){
						if($cnt > 1){
							$store = Store::where('store_code',$row[0])->first();
							// dd($store);
							$category = FormCategory::where('category',strtoupper($row[2]))->first();
							// dd($category);
							$sos = SosTagging::where('sos_tag',strtoupper($row[3]))->first();
							// dd($sos);

							StoreSosTag::insert(array('store_id' => $store->id, 'form_category_id' => $category->id, 'sos_tag_id' => $sos->id));
						}
						$cnt++;	
						
					}
				}
			}else{

			}
		}

		$reader->close();

		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
		Model::reguard();
    }
}
