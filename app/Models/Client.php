<?php

namespace App\Models;

use Database\Factories\ClientFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;
use Modules\Product\Models\ProductQuestion;
use Modules\Review\Models\ProductReview;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Client
 *
 * @property int $id
 * @property string|null $first_name
 * @property string|null $middle_name
 * @property string|null $last_name
 * @property int $subject
 * @property string $phone
 * @property string|null $email
 * @property Carbon|null $banned_at
 * @property Carbon|null $phone_verified_at
 * @property Carbon|null $email_verified_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection|ProductReview[] $productReviews
 * @property-read Collection|ProductQuestion[] $productQuestions
 * @mixin \Eloquent
 * @method static QueryBuilder|Client withoutTrashed()
 * @method static QueryBuilder|Client withTrashed()
 * @method static QueryBuilder|Client onlyTrashed()
 * @method static Builder|Client newModelQuery()
 * @method static Builder|Client newQuery()
 * @method static Builder|Client query()
 */
class Client extends Authenticatable
{
    use SoftDeletes, LogsActivity, HasFactory;

    protected $connection = 'mysql-crm';

    protected $guarded = [
        'id',
        'phone_verified_at',
        'email_verified_at',
    ];

    protected $casts = [
        'banned_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'settings' => 'array',
        'social_networks' => 'array',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'first_name',
                'last_name',
                'subject',
                'phone',
                'email',
            ])
            ->logOnlyDirty();
    }

    public function productReviews(): HasMany
    {
        return $this->hasMany(ProductReview::class);
    }

    public function productQuestions(): HasMany
    {
        return $this->hasMany(ProductQuestion::class);
    }

    protected static function newFactory(): ClientFactory
    {
        return ClientFactory::new();
    }
}
