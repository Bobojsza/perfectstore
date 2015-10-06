<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Account;
use App\Customer;
use App\Area;
use App\Region;
use App\Distributor;
use App\Store;
use App\AuditTemplate;
use App\GradeMatrix;
use App\User;

class ImportMappingTableSeeder extends Seeder
{
    public function run()
    {
    	Model::unguard();
    	DB::statement('SET FOREIGN_KEY_CHECKS=0;');

    	DB::table('audit_templates')->truncate();
        Excel::selectSheets('Store Mapping')->load('/database/seeds/seed_files/Store Mapping.xlsx', function($reader) {
			$records = $reader->get();
			$records->each(function($row) {
				if(!is_null($row->template)){
					$template = AuditTemplate::where('template',$row->template)->first();
					if(count($template) == 0){
						$newtemplate = new AuditTemplate;
						$newtemplate->template = $row->template;
						$newtemplate->save();
					}
				}
			});
		});

		DB::table('grade_matrixs')->truncate();
        Excel::selectSheets('Store Mapping')->load('/database/seeds/seed_files/Store Mapping.xlsx', function($reader) {
			$records = $reader->get();
			$records->each(function($row) {
				if(!is_null($row->enrollment_type)){
					$matrix = GradeMatrix::where('desc',$row->enrollment_type)->first();
					if(count($matrix) == 0){
						$newmatrix = new GradeMatrix;
						$newmatrix->desc = $row->enrollment_type;
						$newmatrix->save();
					}
				}
			});
		});

		DB::table('users')->truncate();	
		DB::table('role_user')->truncate();	
        Excel::selectSheets('Store Mapping')->load('/database/seeds/seed_files/Store Mapping.xlsx', function($reader) {
			$records = $reader->get();
			$records->each(function($row) {
				if(!is_null($row->fullname)){
					$userlist = explode("/", $row->fullname);
					$emaillist = explode("/", $row->email);

					for ($i=0; $i < count($userlist); $i++) { 
						$user = User::where('email',$emaillist[$i])->first();
						if(count($user) == 0){
							$newuser = User::create(array(
						    	'name'     => strtoupper($userlist[$i]),
						        'email'    => strtolower($emaillist[$i]),
						        'username' => strtolower($emaillist[$i]),
						        'password' => Hash::make('password'),
						    ));

						    $newuser->roles()->attach(3);
						}else{
							// $user->name = strtoupper($row->fullname);
							// $user->username = $row->username;
							// $user->email = strtolower($row->email);
							// $user->update();
							// if(!$user->hasRole('field')){
							// 	$user->roles()->attach(3);
							// }

							// echo $user->hasRole('field');
						}
					}
					
				}
			});

		});




    	DB::table('accounts')->truncate();

        Excel::selectSheets('Store Mapping')->load('/database/seeds/seed_files/Store Mapping.xlsx', function($reader) {
			$records = $reader->get();
			$records->each(function($row) {
				if(!is_null($row->account)){
					$account = Account::where('account',$row->account)->first();
					if(count($account) == 0){
						$newaccount = new Account;
						$newaccount->account = $row->account;
						$newaccount->save();
					}
				}
			});

		});

		DB::table('customers')->truncate();

		Excel::selectSheets('Store Mapping')->load('/database/seeds/seed_files/Store Mapping.xlsx', function($reader) {
			$records = $reader->get();
			$records->each(function($row) {
				if(!is_null($row->account)){
					// var_dump($row);
					$account = Account::where('account',$row->account)->first();
					if(!empty($account)){
						$customer = Customer::where('account_id',$account->id)
							->where('customer_code',$row->customer_code)
							->where('customer',$row->customer)
							->first();
						if(count($customer) == 0){
							$newcustomer = new Customer;
							$newcustomer->account_id = $account->id;
							$newcustomer->customer_code = $row->customer_code;
							$newcustomer->customer = $row->customer;
							$newcustomer->save();
						}
					}
				}
			});

		});

		DB::table('areas')->truncate();

		Excel::selectSheets('Store Mapping')->load('/database/seeds/seed_files/Store Mapping.xlsx', function($reader) {
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
							if(count($area) == 0){
								$newarea = new Area;
								$newarea->customer_id = $customer->id;
								$newarea->area = $row->area;
								$newarea->save();
							}
						}
					}
				}
			});

		});

		DB::table('regions')->truncate();

		Excel::selectSheets('Store Mapping')->load('/database/seeds/seed_files/Store Mapping.xlsx', function($reader) {
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
								if(count($region) == 0){
									$newregion = new Region;
									$newregion->area_id = $area->id;
									$newregion->region_code = $row->region_code;
									$newregion->region = $row->region;
									$newregion->save();
								}
							}
						}
					}
				}
			});

		});

		DB::table('distributors')->truncate();

		Excel::selectSheets('Store Mapping')->load('/database/seeds/seed_files/Store Mapping.xlsx', function($reader) {
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
									if(count($dis) == 0){
										$newdis = new Distributor;
										$newdis->region_id = $region->id;
										$newdis->distributor_code = $row->distributor_code;
										$newdis->distributor = $row->distributor;
										$newdis->save();
									}
								}
							}
						}
					}
				}
			});

		});

		DB::table('stores')->truncate();
		DB::table('store_user')->truncate();
		Excel::selectSheets('Store Mapping')->load('/database/seeds/seed_files/Store Mapping.xlsx', function($reader) {
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

											

											$template = AuditTemplate::where('template',$row->template)->first();
											$matrix = GradeMatrix::where('desc',$row->enrollment_type)->first();

											$newstore = new Store;
											$newstore->distributor_id = $dis->id;
											$newstore->store_code = $row->store_code;
											$newstore->store = $row->store_name;
											$newstore->grade_matrix_id = $matrix->id;
											$newstore->audit_template_id = $template->id;
											$newstore->save();

											$emaillist = explode("/", $row->email);

											for ($i=0; $i < count($emaillist); $i++) { 
												$user = User::where('email',$emaillist[$i])->first();
												$newstore->users()->attach($user->id);
											}											
										}
									}
								}
							}
						}
					}
				}
			});

		});

		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
		Model::reguard();

    }
}
