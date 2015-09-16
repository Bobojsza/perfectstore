<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Account;
use App\Customer;
use App\Area;
use App\Region;
use App\Distributor;
use App\Store;

class ImportMappingTableSeeder extends Seeder
{
    public function run()
    {
    	Model::unguard();

  //       Excel::selectSheets('Combined')->load('/database/seeds/seed_files/PS FINAL MAPPING modified.xlsx', function($reader) {
		// 	$records = $reader->get();
		// 	$records->each(function($row) {
		// 		if(!is_null($row->account)){
		// 			$account = Account::where('account',$row->account)->first();
		// 			if(count($account) == 0){
		// 				$newaccount = new Account;
		// 				$newaccount->account = $row->account;
		// 				$newaccount->save();
		// 			}
		// 		}
		// 	});

		// });

		// Excel::selectSheets('Combined')->load('/database/seeds/seed_files/PS FINAL MAPPING modified.xlsx', function($reader) {
		// 	$records = $reader->get();
		// 	$records->each(function($row) {
		// 		if(!is_null($row->account)){
		// 			// var_dump($row);
		// 			$account = Account::where('account',$row->account)->first();
		// 			if(!empty($account)){
		// 				$customer = Customer::where('account_id',$account->id)
		// 					->where('customer_code',$row->customer_code)
		// 					->where('customer',$row->customer)
		// 					->first();
		// 				if(count($customer) == 0){
		// 					$newcustomer = new Customer;
		// 					$newcustomer->account_id = $account->id;
		// 					$newcustomer->customer_code = $row->customer_code;
		// 					$newcustomer->customer = $row->customer;
		// 					$newcustomer->save();
		// 				}
		// 			}
		// 		}
		// 	});

		// });

		// Excel::selectSheets('Combined')->load('/database/seeds/seed_files/PS FINAL MAPPING modified.xlsx', function($reader) {
		// 	$records = $reader->get();
		// 	$records->each(function($row) {
		// 		if(!is_null($row->account)){
		// 			$account = Account::where('account',$row->account)->first();
		// 			if(!empty($account)){
		// 				$customer = Customer::where('account_id',$account->id)
		// 					->where('customer_code',$row->customer_code)
		// 					->where('customer',$row->customer)
		// 					->first();
		// 				if(!empty($customer)){
		// 					$area = Area::where('customer_id',$customer->id)
		// 						->where('area',$row->area)
		// 						->first();
		// 					if(count($area) == 0){
		// 						$newarea = new Area;
		// 						$newarea->customer_id = $customer->id;
		// 						$newarea->area = $row->area;
		// 						$newarea->save();
		// 					}
		// 				}
		// 			}
		// 		}
		// 	});

		// });

		// Excel::selectSheets('Combined')->load('/database/seeds/seed_files/PS FINAL MAPPING modified.xlsx', function($reader) {
		// 	$records = $reader->get();
		// 	$records->each(function($row) {
		// 		if(!is_null($row->account)){
		// 			$account = Account::where('account',$row->account)->first();
		// 			if(!empty($account)){
		// 				$customer = Customer::where('account_id',$account->id)
		// 					->where('customer_code',$row->customer_code)
		// 					->where('customer',$row->customer)
		// 					->first();
		// 				if(!empty($customer)){
		// 					$area = Area::where('customer_id',$customer->id)
		// 						->where('area',$row->area)
		// 						->first();
		// 					if(!empty($area)){
		// 						$region = Region::where('area_id',$area->id)
		// 							->where('region_code',$row->region_code)
		// 							->where('region',$row->region)
		// 							->first();
		// 						if(count($region) == 0){
		// 							$newregion = new Region;
		// 							$newregion->area_id = $area->id;
		// 							$newregion->region_code = $row->region_code;
		// 							$newregion->region = $row->region;
		// 							$newregion->save();
		// 						}
		// 					}
		// 				}
		// 			}
		// 		}
		// 	});

		// });

		// Excel::selectSheets('Combined')->load('/database/seeds/seed_files/PS FINAL MAPPING modified.xlsx', function($reader) {
		// 	$records = $reader->get();
		// 	$records->each(function($row) {
		// 		if(!is_null($row->account)){
		// 			$account = Account::where('account',$row->account)->first();
		// 			if(!empty($account)){
		// 				$customer = Customer::where('account_id',$account->id)
		// 					->where('customer_code',$row->customer_code)
		// 					->where('customer',$row->customer)
		// 					->first();
		// 				if(!empty($customer)){
		// 					$area = Area::where('customer_id',$customer->id)
		// 						->where('area',$row->area)
		// 						->first();
		// 					if(!empty($area)){
		// 						$region = Region::where('area_id',$area->id)
		// 							->where('region_code',$row->region_code)
		// 							->where('region',$row->region)
		// 							->first();
		// 						if(!empty($region)){
		// 							$dis = Distributor::where('region_id',$region->id)
		// 								->where('distributor_code',$row->distributor_code)
		// 								->where('distributor',$row->distributor)
		// 								->first();
		// 							if(count($dis) == 0){
		// 								$newdis = new Distributor;
		// 								$newdis->region_id = $region->id;
		// 								$newdis->distributor_code = $row->distributor_code;
		// 								$newdis->distributor = $row->distributor;
		// 								$newdis->save();
		// 							}
		// 						}
		// 					}
		// 				}
		// 			}
		// 		}
		// 	});

		// });

		Excel::selectSheets('Combined')->load('/database/seeds/seed_files/PS FINAL MAPPING modified.xlsx', function($reader) {
			$records = $reader->get();
			$records->each(function($row) {
				if(!is_null($row->account)){
					$account = Account::where('account',$row->account)->first();
					if(!empty($account)){
						$customer = Customer::where('account_id',$account->id)
							->where('customer_code',$row->customer_code)
							->where('customer',$row->customer)
							->first();
						if(!empty($customer)){
							$area = Area::where('customer_id',$customer->id)
								->where('area',$row->area)
								->first();
							if(!empty($area)){
								$region = Region::where('area_id',$area->id)
									->where('region_code',$row->region_code)
									->where('region',$row->region)
									->first();
								if(!empty($region)){
									$dis = Distributor::where('region_id',$region->id)
										->where('distributor_code',$row->distributor_code)
										->where('distributor',$row->distributor)
										->first();
									if(!empty($dis)){
										$store = Store::where('distributor_id',$dis->id)
											->where('store_code',$row->store_code)
											->where('store',$row->store_name)
											->first();
										if(count($store) == 0){
											$newstore = new Store;
											$newstore->distributor_id = $dis->id;
											$newstore->store_code = $row->store_code;
											$newstore->store = $row->store_name;
											$newstore->save();
										}
									}
								}
							}
						}
					}
				}
			});

		});

		Model::reguard();

    }
}
