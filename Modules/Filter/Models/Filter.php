<?php

namespace Modules\Filter\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use Modules\Category\Models\Category;
use Modules\Filter\Database\factories\FilterFactory;
use Modules\Property\Models\Property;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

/**
 * Class Filter
 * @package Modules\Filter\Models
 * @property int $id
 * @property string $name
 * @property int $status
 * @property bool $is_default
 * @property bool $is_enabled
 * @property int $position
 * @property array $array
 * @property Property|null $property
 * @property Category|null $category
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @mixin \Eloquent
 * @method static Builder|Filter newModelQuery()
 * @method static Builder|Filter newQuery()
 * @method static Builder|Filter query()
 */
class Filter extends Model
{
    use HasFactory,
        LogsActivity,
        HasJsonRelationships;

    protected $guarded = ['id'];

    protected $casts = [
        'type' => 'integer',
        'is_enabled' => 'boolean',
        'is_default' => 'boolean',
        'is_system' => 'boolean',
        'position' => 'integer',
        'options' => 'json',
        'facet' => 'object',
        'is_hide_links_from_code' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class, 'facet->property_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->dontLogIfAttributesChangedOnly([
                'description',
                'created_at',
                'updated_at',
            ])
            ->logOnlyDirty();
    }

    protected static function newFactory()
    {
        return FilterFactory::new();
    }
}
