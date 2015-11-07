<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;


use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

class SubFormTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		DB::table('temp_forms')->truncate();

		$reader = ReaderFactory::create(Type::XLSX); // for XLSX files
		$filePath = 'database/seeds/seed_files/Sub Form.xlsx';
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
