<?php

namespace Modules\Review\Enums;

use App\Enums\BaseEnum;

/**
 * @method static static IN_MODERATION()
 * @method static static APPROVED()
 * @method static static REJECTED()
 */
class ProductReviewStatus extends BaseEnum
{
    const IN_MODERATION = 1;
    const APPROVED = 2;
    const REJECTED = 3;
}
