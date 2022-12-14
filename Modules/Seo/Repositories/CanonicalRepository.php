<?php


namespace Modules\Seo\Repositories;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Collection as SupportCollection;
use Modules\Seo\Models\Canonical;
use Modules\Seo\Repositories\Criteria\CanonicalRequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\QueryBuilder\QueryBuilder as SpatieQueryBuilder;

/**
 * Class CanonicalRepository
 * @package Modules\Seo\Repositories
 * @property Canonical $model
 */
class CanonicalRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Canonical::class;
    }

    public function boot()
    {
        $this->pushCriteria(CanonicalRequestCriteria::class);
    }
}
