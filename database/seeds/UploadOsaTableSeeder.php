<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

use App\Customer;
use App\Region;
use App\Distributor;
use App\Store;
use App\AuditTemplate;
use App\FormCategory;
use App\OsaLookup;
use App\OsaLookupTarget;

class UploadOsaTableSeeder extends Seeder
{
    public function run()
    {
       Model::unguard();

		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		DB::table('osa_lookups')->truncate();
		DB::table('osa_lookup_targets')->truncate();

		$reader = ReaderFactory::create(Type::XLSX); // for XLSX files
		$filePath = 'database/seeds/seed_files/OSA Target.xlsx';
		$reader->open($filePath);

	   // Accessing the sheet name when reading
		foreach ($reader->getSheetIterator() as $sheet) {
			
			if($sheet->getName() == 'Sheet1'){
				$cnt = 0;
				foreach ($sheet->getRowIterator() as $row) {
					if(!is_null($row[0])){
						if($cnt > 0){
							// dd($row);
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
							$template = AuditTemplate::where('template_code',$row[4])->first();
							if(!empty($template)){
								$template_id = $template->id;
							}



							$category = FormCategory::where('category',$row[5])->first();
							if(!empty($category)){
								$osalookup_id = 0;

								$osalookup = OsaLookup::where('customer_id',$customer_id)
									->where('region_id', $region_id)
									->where('distributor_id', $distributor_id)
									->where('store_id', $store_id)
									->where('template_id',$template_id)
									->first();
								if(empty($osalookup)){
									$osalookup = new OsaLookup();
									$osalookup->customer_id = $customer_id;
									$osalookup->region_id = $region_id;
									$osalookup->distributor_id = $distributor_id;
									$osalookup->store_id = $store_id;
									$osalookup->template_id = $template_id;
									$osalookup->save();								
								}

								$osalookup_id = $osalookup->id;

								OsaLookupTarget::create(array('osa_lookup_id' => $osalookup_id, 'category_id' =>  $category->id, 'target' => $row[8], 'total' => $row[9]));						
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
