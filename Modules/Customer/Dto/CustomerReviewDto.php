<?php


namespace Modules\Customer\Dto;


use App\Dto\BaseDto;
use Illuminate\Http\UploadedFile;
use Modules\Customer\Enums\CustomerType;

/**
 * Class CustomerReviewDto
 * @package Modules\Customer\Dto
 */
class CustomerReviewDto extends BaseDto
{
    public ?string $name;

    public ?string $company_name;

    public ?int $product_id;

    public ?string $author;

    public int $type = CustomerType::PrivatePerson;

    public ?string $video;

    public UploadedFile|string|null $review_file;

    public bool $is_in_home = false;

    public ?string $comment;

    public UploadedFile|string|null $logo;
}
