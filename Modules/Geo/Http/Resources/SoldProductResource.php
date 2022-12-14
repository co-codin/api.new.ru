<?php

namespace Modules\Geo\Http\Resources;

use App\Enums\Status;
use App\Http\Resources\BaseJsonResource;
use Modules\Category\Http\Resources\CategoryResource;
use Modules\Product\Http\Resources\ProductResource;

class SoldProductResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'city' => new CityResource($this->whenLoaded('city')),
            'product' => new ProductResource($this->whenLoaded('product')),
        ]);
    }
}
