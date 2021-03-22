<?php

namespace Modules\Brand\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Brand\Database\factories\BrandFactory;
use Cviebrock\EloquentSluggable\Sluggable;

class Brand extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = ['id'];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', '=', 1);
    }

    protected static function newFactory()
    {
        return BrandFactory::new();
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
