<?php


namespace Modules\Achievement\Dto;

use App\Dto\Dto;

class AchievementDto extends Dto
{
    public ?string $name;

    public ?string $image;

    /** @var bool|integer|null */
    public $is_enabled;
}
