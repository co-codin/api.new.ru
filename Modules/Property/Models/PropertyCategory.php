<?php

namespace Modules\Property\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PropertyCategory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'property_category';

    protected static function newFactory()
    {
        return \Modules\Property\Database\factories\PropertyCategoryFactory::new();
    }
}
