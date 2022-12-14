<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Database\Factories\FieldValueFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Modules\Product\Models\Pivots\ProductPropertyPivot;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

/**
 * Class FieldValue
 * @package App\Models
 * @property int $id
 * @property string $value
 * @property string $slug
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class FieldValue extends Model
{
    use HasFactory, HasJsonRelationships, HasFactory;

    protected $guarded = ['id'];

    public function productPropertyPivots()
    {
        return $this->hasManyJson(ProductPropertyPivot::class, 'field_value_ids');
    }

    protected static function newFactory()
    {
        return FieldValueFactory::new();
    }

//    public function sluggable(): array
//    {
//        return [
//            'slug' => [
//                'source' => 'value',
//            ]
//        ];
//    }
}
