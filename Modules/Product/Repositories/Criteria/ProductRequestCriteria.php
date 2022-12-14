<?php


namespace Modules\Product\Repositories\Criteria;


use App\Filters\ContentFilter;
use App\Filters\IsEmptyFilter;
use Illuminate\Database\Eloquent\Builder;
use Modules\Brand\Repositories\Criteria\BrandRequestCriteria;
use Modules\Category\Repositories\Criteria\CategoryRequestCriteria;
use Modules\Product\Http\Filters\CovidProductsFilter;
use Modules\Product\Http\Filters\ProductLiveFilter;
use Modules\Product\Http\Filters\ProductPropertyFilter;
use Modules\Property\Repositories\Criteria\PropertyRequestCriteria;
use Modules\Review\Repositories\Criteria\ProductReviewRequestCriteria;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ProductRequestCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        $includes = request()->input('include') ?? [];

        if(is_string($includes)) {
            $includes = explode(",", $includes);
        }

        return QueryBuilder::for($model)
            ->defaultSort('-id')
            ->allowedFields(array_merge(
                static::allowedProductFields(),
                static::allowedProductVariationFields('product_variations'),
                static::allowedProductVariationFields('main_variation'),
                static::allowedProductAnalogFields('analogs'),
                static::allowedProductAnalogFields('active_analogs'),
                BrandRequestCriteria::allowedBrandFields('brand'),
                CategoryRequestCriteria::allowedCategoryFields('category'),
                CategoryRequestCriteria::allowedCategoryFields('categories'),
                PropertyRequestCriteria::allowedPropertyFields('properties'),
                ProductReviewRequestCriteria::allowedProductReviewFields('product_reviews'),
                [
                    'images.id',
                    'images.image',
                    'images.caption',
                    'images.position',
                ],
            ))
            ->when(in_array("mainVariation", $includes), fn($query) => $query->withMainVariation())
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::exact('article'),
                AllowedFilter::exact('slug'),
                AllowedFilter::partial('name'),
                AllowedFilter::exact('brand_id'),
                AllowedFilter::exact('status'),
                AllowedFilter::exact('group_id'),
                AllowedFilter::exact('image'),
                AllowedFilter::exact('is_in_home'),
                AllowedFilter::exact('warranty'),
                AllowedFilter::partial('short_description'),
                AllowedFilter::partial('full_description'),
                AllowedFilter::exact('is_manually_analogs'),
                AllowedFilter::exact('country_id'),

                AllowedFilter::custom('live', new ProductLiveFilter),

                AllowedFilter::custom('has_video', new IsEmptyFilter('video')),
                AllowedFilter::custom('has_booklet', new IsEmptyFilter('booklet')),

                AllowedFilter::custom('properties', new ProductPropertyFilter),
                AllowedFilter::custom('is_covid', new CovidProductsFilter),

                AllowedFilter::trashed(),

                AllowedFilter::exact('categories.id'),
                AllowedFilter::callback('categories.parent_category_id', function ($query, $value) {
                    $query->whereHas('productCategories', function ($q) use ($value) {
                        $q->where('is_main', true)
                            ->whereIn('category_id', $value);
                    });
                }),

                AllowedFilter::exact('productVariations.id'),
                AllowedFilter::partial('productVariations.name'),
                AllowedFilter::exact('productVariations.is_price_visible'),
                AllowedFilter::exact('productVariations.is_enabled'),
                AllowedFilter::exact('productVariations.currency_id'),
                AllowedFilter::exact('productVariations.price'),
                AllowedFilter::exact('productVariations.availability'),
                AllowedFilter::exact('productVariations.previous_price'),

                AllowedFilter::exact('productReviews.status'),
                AllowedFilter::exact('productReviews.is_confirmed'),

                AllowedFilter::custom('unique_content', new ContentFilter('product')),
                AllowedFilter::custom('no_unique_content', new ContentFilter('product', true)),
            ])
            ->allowedIncludes([
                'brand',
                'productReviews',
                'productReviews.client',
                'productVariations',
                'productVariations.currency',
                'productVariations.productVariationProperties',
                'properties',
                'category',
                'category.ancestors',
                'category.parent',
                'categories',
                'seo',
                'images',
                'mainVariation',
                'mainVariation.currency',
                'stockType',
                'productQuestions',
                'productAnswers',
                'analogs',
                'activeAnalogs',
            ])
            ->allowedSorts('id', 'article', 'slug', 'name', 'warranty', 'is_arbitrary_warranty', 'created_at', 'updated_at', 'deleted_at');
    }

    public static function allowedProductFields($prefix = null)
    {
        $fields = [
            'id',
            'article',
            'slug',
            'status',
            'name',
            'image',
            'position',
            'brand_id',
            'stock_type_id',
            'is_enabled',
            'warranty',
            'warranty_info',
            'is_arbitrary_warranty',
            'arbitrary_warranty_info',
            'group_id',
            'short_description',
            'full_description',
            'is_manually_analogs',
            'country_id',
            'country.value',
            'created_at',
            'updated_at',
        ];

        if(!$prefix) {
            return $fields;
        }

        return array_map(fn($field) => $prefix . "." . $field, $fields);
    }

    public static function allowedProductVariationFields($prefix = null): array
    {
        $fields = [
            'id',
            'product_id',
            'name',
            'price' ,
            'previous_price',
            'currency_id',
            'is_price_visible',
            'is_enabled',
            'availability',
            'condition_id',
            'created_at',
            'updated_at'
        ];

        if(!$prefix) {
            return $fields;
        }

        return array_map(fn($field) => $prefix . "." . $field, $fields);
    }

    public static function allowedProductAnalogFields($prefix = null): array
    {
        $fields = [
            'product_id',
            'analog_id',
            'position',
        ];

        if (!$prefix) {
            return $fields;
        }

        return array_map(fn($field) => $prefix . "." . $field, $fields);
    }
}
