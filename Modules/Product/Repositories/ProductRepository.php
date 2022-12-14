<?php


namespace Modules\Product\Repositories;


use App\Enums\Status;
use App\Repositories\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Modules\Product\Enums\ProductGroup;
use Modules\Product\Http\Resources\ProductResource;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductVariation;
use Modules\Product\Repositories\Criteria\ProductHotCriteria;
use Modules\Product\Repositories\Criteria\ProductListCriteria;
use Modules\Product\Repositories\Criteria\ProductRequestCriteria;
use Modules\Search\Collections\FilteredCollection;
use Modules\Search\Contracts\IndexableRepository;
use Modules\Search\Repositories\IndexableRepositoryTrait;
use Prettus\Repository\Exceptions\RepositoryException;
use Spatie\QueryBuilder\QueryBuilder;

class ProductRepository extends BaseRepository implements IndexableRepository
{
    use IndexableRepositoryTrait;

    public function model()
    {
        return Product::class;
    }

    public function boot()
    {
        $this->pushCriteria(ProductRequestCriteria::class);
    }

    public function getProductsForFeed(?array $filter = [])
    {
        $product = Arr::get($filter, 'product', []);
        $brand = Arr::get($filter, 'brand', []);
        $category = Arr::get($filter, 'category', []);
        $stock_type = Arr::get($filter, 'stock_type', []);
        $has_short_description = Arr::get($filter, 'has_short_description');
        $availability = Arr::get($filter, 'availability', []);
        $has_price = Arr::get($filter, 'has_price');
        $is_price_visible = Arr::get($filter, 'is_price_visible');
        $max_price = Arr::get($filter, 'max_price');
        $min_price = Arr::get($filter, 'min_price');

        return Product::query()
            ->select([
                'products.id',
                'products.name',
                'products.slug',
                'products.brand_id',
                'products.image',
                'products.short_description',
            ])
            ->with([
                'productVariations.currency',
                'category',
                'brand',
                'properties',
                'mainVariation',
            ])
            ->addSelect(['main_variation_id' => ProductVariation::select('product_variations.id')
                ->join('currencies', 'currency_id', 'currencies.id')
                ->whereColumn('product_id', 'products.id')
                ->where('is_enabled', true)
                ->when(!is_null($has_price), function($query) use ($has_price) {
                    $method = $has_price ? "whereNotNull" : "whereNull";
                    return $query->{$method}('price');
                })
                ->when(!is_null($is_price_visible), function($query) use ($is_price_visible) {
                    return $query->where('is_price_visible', $is_price_visible);
                })
                ->when($availability && $availability['ids'], function($query) use ($availability) {
                    $method = $availability['selected'] ? "whereIn" : "whereNotIn";
                    return $query->{$method}("availability", $availability['ids']);
                })
                ->when(!is_null($max_price), function($query) use ($max_price) {
                    return $query->where(function($query) use ($max_price) {
                        $query->whereNull('price')
                            ->orWhereRaw('(rate * price) / 10000 <= ?', [$max_price]);
                    });
                })
                ->when(!is_null($min_price), function($query) use ($min_price) {
                    return $query->where(function($query) use ($min_price) {
                        $query->whereNull('price')
                            ->orWhereRaw('(rate * price) / 10000 >= ?', [$min_price]);
                    });
                })
                ->orderByRaw('rate * price ASC')
                ->take(1),
            ])
            ->where('status', '=', Status::ACTIVE)
            ->havingRaw('main_variation_id is not null')
            ->whereHas('brand', fn ($query) => $query->select(\DB::raw(1))->where('brands.status', Status::ACTIVE))
            ->with('mainVariation')
            ->when($product && $product['ids'], function($query) use ($product) {
                $method = $product['selected'] ? "whereIn" : "whereNotIn";
                return $query->{$method}("id", $product['ids']);
            })
            ->when($brand && $brand['ids'], function($query) use ($brand) {
                $method = $brand['selected'] ? "whereIn" : "whereNotIn";
                return $query->{$method}("brand_id", $brand['ids']);
            })
            ->when($category && $category['ids'], function($query) use ($category) {
                $method = $category['selected'] ? "whereIn" : "whereNotIn";
                return $query->whereHas('productCategories', fn ($query) => $query->{$method}('category_id', $category['ids']));
            })
            ->when($stock_type && $stock_type['ids'], function($query) use ($stock_type) {
                $method = $stock_type['selected'] ? "whereIn" : "whereNotIn";
                return $query->{$method}("stock_type_id", $stock_type['ids']);
            })
            ->when(!is_null($has_short_description), function ($query) use ($has_short_description) {
                $method = $has_short_description ? "whereNotNull" : "whereNull";
                return $query->{$method}('short_description');
            });
    }

    public function getItemsToIndex()
    {
        return $this->scopeQuery(function (QueryBuilder $builder) {
            return $builder->with([
                'brand',
                'category',
                'categories',
                'properties',
                'productVariations',
                'category.ancestors' => function($query) {
                    $query->whereNull('parent_id');
                },
            ]);
        });
    }

    public function getHomeHotProducts()
    {
        return $this->resetCriteria()
            ->pushCriteria(new ProductListCriteria)
            ->pushCriteria(new ProductHotCriteria)
            ->scopeQuery(fn($query) => $query->where('is_in_home', true)->take(20))
            ->get();
    }

    public function getHomeCountryProducts(int $country)
    {
        return $this->resetCriteria()
            ->pushCriteria(new ProductListCriteria)
            ->scopeQuery(function ($query) use($country) {
                return $query->where('is_in_home', true)
                    ->where('group_id', '!=', ProductGroup::IMPOSSIBLE)
                    ->where('country_id', $country)
                    ->take(20);
            })
            ->get();
    }

    public function getHomeCovidProducts()
    {
        return $this->resetCriteria()
            ->pushCriteria(new ProductListCriteria)
            ->scopeQuery(function ($query) {
                return $query->where('is_in_home', true)
                    ->where('group_id', '!=', ProductGroup::IMPOSSIBLE)
                    ->whereExists(function($query) {
                        $query->select(DB::raw(1))
                            ->from('product_property as pp')
                            ->whereColumn('pp.product_id', 'products.id')
                            ->where('pp.property_id', 259)
                            ->whereJsonContains('pp.field_value_ids', 1);
                    })
                    ->take(20);
            })
            ->get();
    }
}
