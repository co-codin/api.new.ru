<?php


namespace Modules\Redirect\Repositories\Criteria;


use App\Http\Filters\LiveFilter;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class RedirectRequestCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return QueryBuilder::for($model)
            ->defaultSort('-id')
            ->allowedFields(['id', 'source', 'destination', 'code', 'created_at', 'updated_at'])
            ->allowedFilters([
                AllowedFilter::custom('live', new LiveFilter([
                    'source' => 'like',
                    'destination' => 'like',
                    'id' => '=',
                ])),
                AllowedFilter::exact('id'),
                AllowedFilter::exact('source'),
                AllowedFilter::exact('destination'),
                AllowedFilter::exact('code'),
            ])
            ->allowedSorts('id', 'source', 'destination', 'code', 'created_at', 'updated_at')
            ;
    }
}
