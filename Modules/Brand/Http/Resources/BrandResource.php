<?php

namespace Modules\Brand\Http\Resources;

use App\Enums\Status;
use App\Http\Resources\BaseJsonResource;
use App\Http\Resources\FieldValueResource;
use Modules\Brand\Models\Brand;
use Modules\Seo\Http\Resources\SeoResource;

/**
 * Class BrandResource
 * @package Modules\Brand\Transformers
 * @mixin Brand
 */
class BrandResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'status' => $this->whenRequested('status', fn() => Status::fromValue($this->status)->toArray()),
            'seo' => new SeoResource($this->whenLoaded('seo')),
            'country' => new FieldValueResource($this->whenLoaded('country')),
        ]);
    }
}
