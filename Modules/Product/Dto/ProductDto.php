<?php

namespace Modules\Product\Dto;

use App\Dto\BaseDto;
use App\Enums\Status;

class ProductDto extends BaseDto
{
    public ?array $categories;

    public $brand_id;

    public ?string $name;

    public ?string $slug;

    public string|null $image;

    public ?string $short_description;

    public ?string $full_description;

    public ?int $warranty;

    public ?string $warranty_info;

    public ?string $arbitrary_warranty_info;

    public ?bool $is_arbitrary_warranty;

    public ?int $status = Status::INACTIVE;

    public $is_in_home = false;

    public $has_test_drive = false;

    public ?array $documents;

    public ?array $benefits;

    public ?bool $is_manually_analogs;

    public ?int $assigned_by_id;

    public ?int $group_id;

    public ?string $stock_type_id;

    public $is_booklet_changed;

    public string|null $booklet;

    public ?string $video;

    public ?int $country_id;
}
