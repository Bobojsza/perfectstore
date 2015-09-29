<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(FormtypesTableSeeder::class);
        $this->call(FormcategoriesTableSeeder::class);
        $this->call(FormgroupsTableSeeder::class);
        $this->call(RoleTableSeeder::class);

        Model::reguard();
    }
}
