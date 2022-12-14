<?php


namespace Modules\Filter\Repositories\Criteria;


use App\Http\Filters\LiveFilter;
use App\Http\Sorts\NullsLast;
use Modules\Category\Repositories\Criteria\CategoryRequestCriteria;
use Modules\Property\Repositories\Criteria\PropertyRequestCriteria;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class FilterRequestCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return QueryBuilder::for($model)
            ->defaultSort('-id')
            ->allowedFields(array_merge(
                self::allowedFilterFields(),
                CategoryRequestCriteria::allowedCategoryFields('category'),
                CategoryRequestCriteria::allowedCategoryFields('category.ancestors'),
                PropertyRequestCriteria::allowedPropertyFields('property'),
            ))
            ->allowedFilters([
                AllowedFilter::custom('live', new LiveFilter([
                    'id' => '=',
                    'name' => 'like',
                    'slug' => 'like',
                ])),
                AllowedFilter::exact('id'),
                AllowedFilter::partial('name'),
                AllowedFilter::exact('type'),
                AllowedFilter::exact('slug'),
                AllowedFilter::exact('category_id'),
                AllowedFilter::exact('is_system'),
                AllowedFilter::exact('is_hide_links_from_code'),
                AllowedFilter::partial('description'),
                AllowedFilter::exact('is_enabled'),
                AllowedFilter::exact('is_default'),
                AllowedFilter::exact('property_id', 'facet->property_id'),
                AllowedFilter::exact('options->field'),
            ])
            ->allowedIncludes('category', 'property', 'category.ancestors')
            ->allowedSorts([
                'id',
                'name',
                'slug',
                AllowedSort::custom('position', new NullsLast),
                'type',
                'created_at',
                'updated_at',
                'deleted_at',
            ]);
    }

    public static function allowedFilterFields($prefix = null): array
    {
        $fields = [
            'id', 'name', 'type', 'slug', 'category_id', 'description', 'facet',
            'is_enabled', 'is_default', 'options', 'position', 'is_hide_links_from_code',
            'created_at', 'is_system',
        ];

        if(!$prefix) {
            return $fields;
        }

        return array_map(fn($field) => $prefix . "." . $field, $fields);
    }
}
