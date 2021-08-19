<?php

namespace Modules\Filter\Concerns;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Modules\Category\Entities\Category;
use Modules\Filter\Entities\Filter;
use Modules\Search\Aggregations\BucketsAggregation;
use Modules\Search\Aggregations\FilterAggregation;
use Modules\Search\Aggregations\NestedAggregation;
use Modules\Search\Contracts\Aggregation;
use Modules\Search\Filters\TermFilter;

trait Aggregable
{
    public function isNotEmpty() : bool
    {
        return !! $this->aggregation;
    }

    public function fillAggregation($aggregation)
    {
        if($aggregationFormatter = Arr::get($this->options, 'aggregationFormatter')) {
            $aggregationFormatter = app($aggregationFormatter);
            $aggregation = $aggregationFormatter->format($aggregation);
        }

        $this->setAttribute('aggregation', $aggregation);
    }

    public function getAggregationAttribute($value)
    {
        return $value;
    }

    public function getAggregationPath() : string
    {
        $path = [
            'aggregations',
            'filtered',
            $this->path,
            $this->slug,
            Arr::get($this->options, 'property_id') ? 'filtered' : null
        ];

        return implode('.', array_filter($path));
    }

    protected function getAggregation() : Aggregation
    {
        return new BucketsAggregation($this->slug, $this->field);
    }

    /**
     * @return array|Collection
     */
    public function toAggregation() : array
    {
        $aggregation = $this->getAggregation();

        if($property = Arr::get($this->options, 'property_id')) {
            $propertyFilter = (new TermFilter($this->path . '.key', $property))->toFilter();
            $aggregation = new FilterAggregation($this->slug, $propertyFilter, [$aggregation]);
        }

        if($this->path) {
            $aggregation = new NestedAggregation($this->path, [$aggregation]);
        }

        return $aggregation->toAggregation();
    }
}
