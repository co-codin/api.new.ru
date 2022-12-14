<?php

namespace Modules\Product\Repositories\Criteria;

use App\Http\Filters\DateFilter;
use App\Http\Filters\LiveFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ProductAnswerRequestCriteria implements CriteriaInterface
{
    /**
     * @param string|Builder|Model $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return QueryBuilder::for($model)
            ->defaultSort('-id')
            ->allowedFields(self::allowedProductAnswerFields())
            ->allowedFilters([
                'text',
                'name',
                'live' => AllowedFilter::custom('live', new LiveFilter([
                    'id' => '=',
                ])),
                'id' => AllowedFilter::exact('id'),
                'product_question_id' => AllowedFilter::exact('product_question_id'),
                'like' => AllowedFilter::exact('like'),
                'dislike' => AllowedFilter::exact('dislike'),
                'date' => AllowedFilter::custom('date', new DateFilter(), 'date'),
                AllowedFilter::trashed(),
            ])
            ->allowedSorts([
                'id',
                'product_question_id',
                'text',
                'name',
                'like',
                'dislike',
                'date',
            ])
            ->allowedIncludes([
                'productQuestion', 'productQuestion.product', 'productQuestion.product.brand',
            ]);
    }

    public static function allowedProductAnswerFields($prefix = null): array
    {
        $fields = [
            'id',
            'product_question_id',
            'text',
            'name',
            'like',
            'dislike',
            'date',
        ];

        if (!$prefix) {
            return $fields;
        }

        return array_map(static fn($field) => $prefix . "." . $field, $fields);
    }
}
