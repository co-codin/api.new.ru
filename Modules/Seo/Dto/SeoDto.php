<?php


namespace Modules\Seo\Dto;


use App\Dto\BaseDto;

/**
 * Class SeoDto
 * @package Modules\Seo\Dto\Admin
 */
class SeoDto extends BaseDto
{
    public $is_enabled = false;

    public ?string $title;

    public ?string $h1;

    public ?string $description;

    public ?array $meta_tags;
}
