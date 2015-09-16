<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Account;
use App\Customer;
use App\Area;
use App\Region;
use App\Distributor;
use App\Store;

class StoreController extends Controller
{
	
	public function stores(){
		$accounts = Account::all();
		$data = array();

		foreach ($accounts as $account){
			$customers = Customer::where('account_id',$account->id)->get();
			$account_children = array();
			foreach ($customers as $customer){
				$areas = Area::where('customer_id',$customer->id)->get();
				$customer_children = array();
				foreach ($areas as $area) {
					$regions = Region::where('area_id',$area->id)->get();
					$area_children = array();
					foreach ($regions as $region) {
						$distributors = Distributor::where('region_id',$region->id)->get();
						$region_children = array();
						foreach ($distributors as $distributor) {
							$stores = Store::where('distributor_id',$distributor->id)->get();
							$distributor_children = array();
							foreach ($stores as $store) {
								$distributor_children[] = array(
									'title' => $store->store,
									'key' => $account->id.".".$customer->id.".".$area->id.".".$region->id.".".$distributor->id.".".$store->id,
									);
							}
							$region_children[] = array(
								'select' => true,
								'title' => $distributor->distributor,
								'isFolder' => true,
								'key' => $account->id.".".$customer->id.".".$area->id.".".$region->id.".".$distributor->id,
								'children' => $distributor_children,
								);
						}
						$area_children[] = array(
							'select' => true,
							'title' => $region->region,
							'isFolder' => true,
							'key' => $account->id.".".$customer->id.".".$area->id.".".$region->id,
							'children' => $region_children,
							);
					}
					$customer_children[] = array(
						'select' => true,
						'title' => $area->area,
						'isFolder' => true,
						'key' => $account->id.".".$customer->id.".".$area->id,
						'children' => $area_children,
						);
				}
				$account_children[] = array(
					'select' => true,
					'title' => $customer->customer,
					'isFolder' => true,
					'key' => $account->id.".".$customer->id,
					'children' => $customer_children,
					);
			}
			$data[] = array(
				'title' => $account->account,
				'isFolder' => true,
				'key' => $account->id,
				'children' => $account_children,
				);
		}
		return response()->json($data);
	}

	
}
