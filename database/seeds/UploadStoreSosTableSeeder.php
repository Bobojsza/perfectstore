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
    	$folderpath = 'database/seeds/seed_files';
		$folders = File::directories($folderpath);
		$latest = '11232015';
		foreach ($folders as $value) {
			$_dir = explode("/", $value);
			$cnt = count($_dir);
			$name = $_dir[$cnt - 1];
			$latest_date = DateTime::createFromFormat('mdY', $latest);
			$now = DateTime::createFromFormat('mdY', $name);
			if($now > $latest_date){
				$latest = $name;
			}
		}

		$file_path = $folderpath."/".$latest."/Store SOS.xlsx";
		echo (string)$file_path, "\n";
		
        Model::unguard();

		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		DB::table('store_sos_tags')->truncate();

		$reader = ReaderFactory::create(Type::XLSX); // for XLSX files
		$filePath = $file_path;
		$reader->open($filePath);

	   // Accessing the sheet name when reading
		foreach ($reader->getSheetIterator() as $sheet) {
			if($sheet->getName() == 'Sheet1'){
				$cnt = 0;
				foreach ($sheet->getRowIterator() as $row) {
					if(!empty($row[0])){
						// dd($row);
						if($cnt > 0){
							// dd($row);
							$store = Store::where('store_code',$row[0])->first();
							// dd($store);
							$category = FormCategory::where('category',strtoupper($row[2]))->first();
							// dd($category);
							$sos = SosTagging::where('sos_tag',strtoupper($row[3]))->first();
							// dd($sos);
							StoreSosTag::insert(array('store_id' => $store->id, 'form_category_id' => $category->id, 'sos_tag_id' => $sos->id));
							// echo (string)$row[0], "\n";
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
