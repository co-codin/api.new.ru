<?php

namespace App\Services\Search;

use App\Services\Interfaces\SearchInterface;
use Illuminate\Support\Facades\DB;

class ProductSearch implements SearchInterface
{
    public function search($query, array $mapping)
    {
        $builder = DB::table('products')
            ->select([
                'products.id',
                'products.name',
                DB::raw("'products' AS type"),
                DB::raw("'Товары' AS type_ru"),
                DB::raw("
                    CONCAT_WS('/', 'https://medeq.ru', 'product', slug, products.id) AS public_url
                "),
                DB::raw("
                    CONCAT_WS('/', 'https://control.medeq.ru/products', products.id, 'update') AS admin_url
                ")
            ])
            ->leftJoin('seo', function ($leftJoin) {
                $leftJoin->on('seo.seoable_id', '=', 'products.id')
                    ->where('seo.seoable_type', 'LIKE', '%product%');
            })
            ;

        foreach ($mapping['columns'] as $column) {
            $builder->orWhere(
                DB::raw("regexp_replace({$column}, '[^A-ZА-Яа-яa-z0-9]', '')"),
                'LIKE',
                "%{$query}%"
            );
        }

        return $builder->get();
    }
}
