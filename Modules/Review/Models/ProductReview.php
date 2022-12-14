<?php

namespace Modules\Review\Models;

use App\Models\Client;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Modules\Product\Models\Product;
use Modules\Review\Database\factories\ProductReviewFactory;
use Modules\Review\Enums\ProductReviewStatus;

/**
 * Class ProductReview
 * @package Modules\Review\Models
 * @property int $id
 * @property int $product_id
 * @property int|null $client_id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property int $experience
 * @property string $advantages
 * @property string $disadvantages
 * @property string $comment
 * @property int $status
 * @property boolean $is_confirmed
 * @property array $ratings
 * @property int $like
 * @property int $dislike
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property float $ratings_avg
 * @property-read Product $product
 * @property-read Client $client
 * @mixin \Eloquent
 * @method static Builder|ProductReview newModelQuery()
 * @method static Builder|ProductReview newQuery()
 * @method static Builder|ProductReview query()
 */
class ProductReview extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'status',
    ];

    protected $casts = [
        'ratings' => 'array',
        'answered_at' => 'date:Y-m-d',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function getRatingsAvgAttribute(): float
    {
        $ratingsRate = \Arr::pluck($this->ratings ?? [], 'rate');

        return !empty($ratingsRate) ? round(array_sum($ratingsRate) / count($ratingsRate), 1) : 0;
    }

    protected static function newFactory(): ProductReviewFactory
    {
        return ProductReviewFactory::new();
    }

    public function scopePublished($query)
    {
        $query->where('status', ProductReviewStatus::APPROVED);
    }
}
