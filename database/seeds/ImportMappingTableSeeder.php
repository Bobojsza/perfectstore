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
		Excel::selectSheets('Sheet1')->load('/database/seeds/seed_files/Store Mapping.xlsx', function($reader) {
			$records = $reader->get();
			$records->each(function($row) {
				if(!is_null($row->template)){
					$template = AuditTemplate::where('template',$row->template)->first();
					if(count($template) == 0){
						$newtemplate = new AuditTemplate;
						$newtemplate->template_code = $row->channel_code;
						$newtemplate->template = $row->template;
						$newtemplate->save();
					}
				}
			});
		});

		DB::table('grade_matrixs')->truncate();
		Excel::selectSheets('Sheet1')->load('/database/seeds/seed_files/Store Mapping.xlsx', function($reader) {
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
		Excel::selectSheets('Sheet1')->load('/database/seeds/seed_files/Store Mapping.xlsx', function($reader) {
			$records = $reader->get();
			$records->each(function($row) {
				if(!is_null($row->fullname)){
					$userlist = explode("/", $row->fullname);
					$emaillist = explode("/", $row->email);

					for ($i=0; $i < count($userlist); $i++) { 
						$user = User::where('username',$row->username)->first();
						if(count($user) == 0){
							if(empty($emaillist[$i])){
								$email = strtolower($row->username."@unilever.com");
							}else{
								$email = strtolower($emaillist[$i]);
							}
							$newuser = User::create(array(
								'name'     => strtoupper($userlist[$i]),
								'email'    => $email,
								'username' => $row->username,
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

		Excel::selectSheets('Sheet1')->load('/database/seeds/seed_files/Store Mapping.xlsx', function($reader) {
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

		Excel::selectSheets('Sheet1')->load('/database/seeds/seed_files/Store Mapping.xlsx', function($reader) {
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

		Excel::selectSheets('Sheet1')->load('/database/seeds/seed_files/Store Mapping.xlsx', function($reader) {
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

		Excel::selectSheets('Sheet1')->load('/database/seeds/seed_files/Store Mapping.xlsx', function($reader) {
			$records = $reader->get();
			$records->each(function($row) {
				if(!is_null($row->account)){
					$region = Region::where('region_code',$row->region_code)
						->where('region',$row->region)
						->first();
					if(count($region) == 0){
						$newregion = new Region;
						$newregion->region_code = $row->region_code;
						$newregion->region = $row->region;
						$newregion->save();
					}
				}
			});

		});


		DB::table('distributors')->truncate();

		Excel::selectSheets('Sheet1')->load('/database/seeds/seed_files/Store Mapping.xlsx', function($reader) {
			$records = $reader->get();
			$records->each(function($row) {
				if(!is_null($row->account)){
					$dis = Distributor::where('distributor_code',$row->distributor_code)
						->where('distributor',$row->distributor)
						->first();
					if(count($dis) == 0){
						$newdis = new Distributor;
						$newdis->distributor_code = $row->distributor_code;
						$newdis->distributor = strtoupper($row->distributor);
						$newdis->save();
					}
				}
			});

		});

		DB::table('stores')->truncate();
		DB::table('store_user')->truncate();
		Excel::selectSheets('Sheet1')->load('/database/seeds/seed_files/Store Mapping.xlsx', function($reader) {
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

							$region = Region::where('region_code',$row->region_code)->first();
							$dis = Distributor::where('distributor_code',$row->distributor_code)->first();

							$store = Store::where('account_id',$account->id)
								->where('customer_id',$customer->id)
								->where('region_id',$region->id)
								->where('distributor_id',$dis->id)
								->where('store_code',$row->store_code)
								->where('store',$row->store_name)
								->first();
							if(count($store) == 0){
								$template = AuditTemplate::where('template',$row->template)->first();
								$matrix = GradeMatrix::where('desc',$row->enrollment_type)->first();
								
								$newstore = new Store;
								$newstore->account_id = $account->id;
								$newstore->customer_id = $customer->id;
								$newstore->region_id = $region->id;
								$newstore->distributor_id = $dis->id;
								$newstore->store_code = $row->store_code;
								$newstore->store = $row->store_name;
								$newstore->grade_matrix_id = $matrix->id;
								$newstore->audit_template_id = $template->id;
								$newstore->save();

								$emaillist = explode("/", $row->email);

								for ($i=0; $i < count($emaillist); $i++) { 
									if(empty($emaillist[$i])){
										$email = strtolower($row->username."@unilever.com");
									}else{
										$email = strtolower($emaillist[$i]);
									}
									$user = User::where('email',$email)->first();
									$newstore->users()->attach($user->id);
								}											
							}else{
								$emaillist = explode("/", $row->email);

								for ($i=0; $i < count($emaillist); $i++) { 
									if(empty($emaillist[$i])){
										$email = strtolower($row->username."@unilever.com");
									}else{
										$email = strtolower($emaillist[$i]);
									}
									$user = User::where('email',$email)->first();
									$store->users()->attach($user->id);
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
