<?php

namespace Modules\Activity\Repositories\Criteria;

use App\Http\Filters\LiveFilter;
use Modules\Activity\Http\Filters\SubjectTypeFilter;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ActivityRequestCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return QueryBuilder::for($model)
            ->defaultSort('-id')
            ->allowedFields(array_merge(
                static::allowedActivityFields('activities'),
            ))
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::exact('subject_id'),
                AllowedFilter::exact('event'),
                AllowedFilter::partial('causer_id'),

                AllowedFilter::custom('subject_type', new SubjectTypeFilter),

                AllowedFilter::custom('live', new LiveFilter([
                    'id' => '=',
                    'subject_id' => '=',
                    'properties' => 'like',
                ])),
            ])
            ->allowedIncludes([
                'causer',
                'subject',
                'parentSubject',
            ])
            ->allowedSorts([
                'id',
                'log_name',
                'description',
                'subject_type',
                'subject_id',
                'event',
                'causer_type',
                'causer_id',
                'created_at',
                'updated_at',
            ]);
    }

    public static function allowedActivityFields($prefix = null): array
    {
        $fields = [
            'id',
            'log_name',
            'description',
            'subject_type',
            'subject_id',
            'event',
            'causer_type',
            'causer_id',
            'properties',
            'created_at',
            'updated_at',
        ];

        if(!$prefix) {
            return $fields;
        }

        return array_map(fn($field) => $prefix . "." . $field, $fields);
    }
}
