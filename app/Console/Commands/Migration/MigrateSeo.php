<?php

namespace App\Console\Commands\Migration;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Seo\Models\Seo;

class MigrateSeo extends Command
{
    protected $signature = 'migrate:seo';

    protected $description = 'Migrate seo';

    public function handle()
    {
        Model::unguard();

        $oldSeos = DB::connection('old_medeq_mysql')
            ->table('seo')
            ->get();

        foreach ($oldSeos as $oldSeo) {
            Seo::query()->insert(
                $this->transform($oldSeo)
            );
        }
    }

    // Product.category.childSeo - seo
    // Category - seo
    // ProductCategory - seo

    // product.vue
    // product.seo.is_enabled = true ?? product.seotype2.is_enabled = 2 ?? product.name
    // <производитель> <модель> - купить телефоны дешево

    protected function transform($item)
    {
        return [
            'id' => $item->id,
            'seoable_type' => !is_null($item->seoable_type)
                ? str_replace('Entities', 'Models', $item->seoable_type)
                : $item->seoable_type,
            'seoable_id' => $item->seoable_id,
            'is_enabled' => $item->is_enabled,
            'title' => $item->title,
            'description' => $item->description,
            'h1' => $item->h1,
            'meta_tags' => $item->meta_tags && $item->meta_tags !== "[]" ? $item->meta_tags : null,
            'type' => $item->type,
        ];
    }
}
