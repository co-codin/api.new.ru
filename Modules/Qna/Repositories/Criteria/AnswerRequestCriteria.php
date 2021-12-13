<?php

namespace Modules\Qna\Repositories\Criteria;

use App\Http\Filters\DateFilter;
use App\Http\Filters\LiveFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\QueryBuilder;

class AnswerRequestCriteria implements CriteriaInterface
{
    /**
     * @param string|Builder|Model $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
//        return (new AnswerBuilder())->builder($model);
        return QueryBuilder::for($model)
            ->defaultSort('-id')
            ->allowedFields(array_merge(
                self::allowedAnswerFields(),
            ))
            ->allowedFilters([
                'text',
                'name',
                'live' => AllowedFilter::custom('live', new LiveFilter([
                    'id' => '=',
                ])),
                'id' => AllowedFilter::exact('id'),
                'question_id' => AllowedFilter::exact('question_id'),
                'like' => AllowedFilter::exact('like'),
                'dislike' => AllowedFilter::exact('dislike'),
                'created_at' => AllowedFilter::custom('created_at', new DateFilter(), 'created_at'),
                AllowedFilter::trashed(),
            ])
            ->allowedSorts([
                'id',
                'question_id',
                'text',
                'name',
                'like',
                'dislike',
                'created_at',
            ])
            ->allowedIncludes([
                'question',
                AllowedInclude::count('answersCount'),
            ]);
    }

    public static function allowedAnswerFields($prefix = null): array
    {
        $fields = [
            'id',
            'question_id',
            'text',
            'name',
            'like',
            'dislike',
            'created_at',
        ];

        if (!$prefix) {
            return $fields;
        }

        return array_map(static fn($field) => $prefix . "." . $field, $fields);
    }
}
