<?php

namespace Modules\Geo\Http\Resources;

use App\Enums\Status;
use App\Http\Resources\BaseJsonResource;
use Modules\Geo\Enums\OrderPointType;
use Modules\Geo\Models\OrderPoint;

/**
 * Class OrderPointResource
 * @package Modules\Geo\Http\Resources
 * @mixin OrderPoint
 */
class OrderPointResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'status' => $this->whenRequested('status', Status::fromValue($this->status)),
            'city' => new CityResource($this->whenLoaded('city')),
            'type' => $this->whenRequested('type', OrderPointType::fromValue($this->type)),
        ]);
    }
}
