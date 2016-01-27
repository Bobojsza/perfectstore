<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;


use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

class SubFormTableSeeder extends Seeder
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

		$file_path = $folderpath."/".$latest."/Sub Form.xlsx";
		echo (string)$file_path, "\n";

        Model::unguard();

		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		DB::table('temp_forms')->truncate();

		$reader = ReaderFactory::create(Type::XLSX); // for XLSX files
		$filePath = $file_path;
		$reader->open($filePath);

	   	// Accessing the sheet name when reading
		foreach ($reader->getSheetIterator() as $sheet) {
			if($sheet->getName() == 'Sheet1') {
				$cnt = 0;
				foreach ($sheet->getRowIterator() as $row) {
					if($cnt > 0){
						if(!is_null($row[2])){
							$prompt = addslashes($row[1]);
							DB::statement('INSERT INTO temp_forms (code, prompt, required, type, choices, expected_answer) VALUES ("'.$row[0].'","'.$prompt.'","'.$row[2].'","'.$row[3].'","'.$row[4].'","'.$row[6].'");');
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
