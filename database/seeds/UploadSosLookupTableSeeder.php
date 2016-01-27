<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Customer;
use App\Region;
use App\Distributor;
use App\Store;
use App\AuditTemplate;
use App\FormCategory;
use App\SosLookup;
use App\SosLookupPercentage;

use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

class UploadSosLookupTableSeeder extends Seeder
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

		$file_path = $folderpath."/".$latest."/SOS Target.xlsx";
		echo (string)$file_path, "\n";
		
		Model::unguard();

		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		DB::table('sos_lookups')->truncate();
		DB::table('sos_lookup_percentages')->truncate();

		$reader = ReaderFactory::create(Type::XLSX); // for XLSX files
		$filePath = $file_path;
		$reader->open($filePath);

	   // Accessing the sheet name when reading
		foreach ($reader->getSheetIterator() as $sheet) {
			// dd($sheet);
			if($sheet->getName() == 'Sheet1'){
				$cnt = 0;
				foreach ($sheet->getRowIterator() as $row) {
					if(!is_null($row[0])){
						if($cnt > 0){
							$caip = $row[9];
						$noncaip = str_replace("%","",$row[10])/100;

						if(($caip > 0) || ($noncaip > 0)){
							$customer_id = 0;
							$customer = Customer::where('customer_code',$row[0])->first();
							if(!empty($customer)){
								$customer_id = $customer->id;
							}

							$region_id = 0;
							$region = Region::where('region_code',$row[1])->first();
							if(!empty($region)){
								$region_id = $region->id;
							}

							$distributor_id = 0;
							$distributor = Distributor::where('distributor_code',$row[2])->first();
							if(!empty($distributor)){
								$distributor_id = $distributor->id;
							}

							$store_id = 0;
							$store = Store::where('store_code',$row[3])->first();
							if(!empty($store)){
								$store_id = $store->id;
							}

							$template_id = 0;
							$template = AuditTemplate::where('template',$row[4])->first();
							if(!empty($template)){
								$template_id = $template->id;
							}

							$category = FormCategory::where('category',$row[5])->first();
							if(!empty($category)){
								$soslookup_id = 0;

								$soslookup = SosLookup::where('customer_id',$customer_id)
									->where('region_id', $region_id)
									->where('distributor_id', $distributor_id)
									->where('store_id', $store_id)
									->where('template_id',$template_id)
									->first();
								if(!empty($soslookup)){
									$soslookup_id = $soslookup->id;
								}else{
									$soslookup = new SosLookup();
									$soslookup->customer_id = $customer_id;
									$soslookup->region_id = $region_id;
									$soslookup->distributor_id = $distributor_id;
									$soslookup->store_id = $store_id;
									$soslookup->template_id = $template_id;
									$soslookup->save();

									$soslookup_id = $soslookup->id;
								}

								

								SosLookupPercentage::create(array('sos_lookup_id' => $soslookup_id, 'category_id' =>  $category->id, 'sos_id' => 1, 'less' => 0.015, 'value' => $row[9]));
								SosLookupPercentage::create(array('sos_lookup_id' => $soslookup_id, 'category_id' =>  $category->id,'sos_id' => 2, 'less' => 0.015, 'value' => $row[10]));
							}

							
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
