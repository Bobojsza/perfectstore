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
        $this->call(RoleTableSeeder::class);

        $this->call(SosTableSeeder::class);

        $this->call(ImportMappingTableSeeder::class);
        $this->call(ImportAuditTemplateTableSeeder::class);

        $this->call(UploadSosLookupTableSeeder::class);

        $this->call(UploadSecondaryDisplayTableSeeder::class);
        $this->call(UploadSecondaryDisplayLookupTableSeeder::class);

        $this->call(UploadOsaTableSeeder::class);

        Model::reguard();
    }
}
