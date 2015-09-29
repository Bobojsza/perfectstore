<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;

class ImportUserTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        // DB::table('users')->truncate();	

        Excel::selectSheets('Store Mapping')->load('/database/seeds/seed_files/Store Mapping.xlsx', function($reader) {
			$records = $reader->get();
			$records->each(function($row) {
				if(!is_null($row->fullname)){
					$user = User::where('email',$row->email)->first();
					if(count($user) == 0){
						User::create(array(
					    	'name'     => strtoupper($row->fullname),
					        'email'    => strtolower($row->email),
					        'username'    => strtolower($row->email),
					        'password' => Hash::make('password'),
					    ));
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
			});

		});

        
		Model::reguard();
    }
}
