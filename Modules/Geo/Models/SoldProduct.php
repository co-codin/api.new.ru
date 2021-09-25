<?php

namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Category\Models\Category;
use Modules\Product\Models\Product;

class SoldProduct extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'title',
        'product_id',
        'city_id',
        'category_id',
        'type',
        'status',
    ];

    public function product()
    {
        return $this->hasOne(Product::class, 'id','product_id');
    }

    public function city()
    {
        return $this->hasOne(City::class, 'id','city_id');
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id','category_id');
    }
}