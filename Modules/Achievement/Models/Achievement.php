<?php

namespace Modules\Achievement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Achievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'status',
        'position',
    ];

    protected static function newFactory()
    {
        return \Modules\Achievement\Database\factories\AchievementFactory::new();
    }
}
