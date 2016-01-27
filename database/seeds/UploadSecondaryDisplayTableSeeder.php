	<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

use App\SecondaryDisplay;
use App\FormCategory;

class UploadSecondaryDisplayTableSeeder extends Seeder
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

		$file_path = $folderpath."/".$latest."/Secondary Display.xlsx";
		echo (string)$file_path, "\n";
		
        Model::unguard();

		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		DB::table('secondary_displays')->truncate();

		$reader = ReaderFactory::create(Type::XLSX); // for XLSX files
		$filePath = $file_path;
		$reader->open($filePath);

	   // Accessing the sheet name when reading
		foreach ($reader->getSheetIterator() as $sheet) {
			if($sheet->getName() == 'Sheet2'){
				$cnt = 0;
				foreach ($sheet->getRowIterator() as $row) {
					if(!is_null($row[0])){
						if($cnt > 0){
							$category = FormCategory::firstOrCreate(['category'=>strtoupper($row[0])]);
							$category->secondary_display = 1;
							$category->update();
							if(!empty($category)){
								SecondaryDisplay::create(array('category_id' => $category->id, 
									'brand' =>  $row[1]));
							}
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
