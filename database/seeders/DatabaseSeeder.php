<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Achievement\Database\Seeders\AchievementDatabaseSeeder;
use Modules\Brand\Database\Seeders\BrandDatabaseSeeder;
use Modules\Category\Database\Seeders\CategoryDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(AchievementDatabaseSeeder::class);
        $this->call(BrandDatabaseSeeder::class);
        $this->call(CategoryDatabaseSeeder::class);
    }
}
