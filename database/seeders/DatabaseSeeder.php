<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Achievement\Database\Seeders\AchievementDatabaseSeeder;
use Modules\Brand\Database\Seeders\BrandDatabaseSeeder;
use Modules\Category\Database\Seeders\CategoryDatabaseSeeder;
use Modules\Currency\Database\Seeders\CurrencyDatabaseSeeder;
use Modules\Faq\Database\Seeders\FaqDatabaseSeeder;
use Modules\Geo\Database\Seeders\GeoDatabaseSeeder;
use Modules\News\Database\Seeders\NewsDatabaseSeeder;
use Modules\Page\Database\Seeders\PageDatabaseSeeder;
use Modules\Product\Database\Seeders\ProductDatabaseSeeder;
use Modules\Property\Database\Seeders\PropertyDatabaseSeeder;
use Modules\Publication\Database\Seeders\PublicationDatabaseSeeder;
use Modules\Redirect\Database\Seeders\RedirectDatabaseSeeder;
use Modules\Seo\Database\Seeders\CanonicalDatabaseSeeder;
use Modules\Seo\Database\Seeders\SeoDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
//        $this->call(AchievementDatabaseSeeder::class);
//        $this->call(BrandDatabaseSeeder::class);
//        $this->call(CategoryDatabaseSeeder::class);
//        $this->call(SeoDatabaseSeeder::class);
//        $this->call(CanonicalDatabaseSeeder::class);
//        $this->call(FaqDatabaseSeeder::class);
//        $this->call(NewsDatabaseSeeder::class);
//        $this->call(PageDatabaseSeeder::class);
//        $this->call(RedirectDatabaseSeeder::class);
//        $this->call(PublicationDatabaseSeeder::class);
//        $this->call(PropertyDatabaseSeeder::class);
////        $this->call(FilterDatabaseSeeder::class);
//        $this->call(CurrencyDatabaseSeeder::class);
//        $this->call(ProductDatabaseSeeder::class);
        $this->call(GeoDatabaseSeeder::class);
    }
}
