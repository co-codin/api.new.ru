<?php

namespace Modules\Geo\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class GeoDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(RegionTableSeeder::class);
        $this->call(CityTableSeeder::class);
    }
}
