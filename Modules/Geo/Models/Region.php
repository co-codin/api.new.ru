<?php

namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Geo\Database\factories\RegionFactory;

class Region extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    protected static function newFactory()
    {
        return RegionFactory::new();
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}