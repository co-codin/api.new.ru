<?php


namespace Modules\Product\Http\Resources;


use App\Http\Resources\BaseJsonResource;

class ProductVariationResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'currency' => $this->whenLoaded('currency'),
            'variation_links' => VariationLinkResource::collection($this->whenLoaded('variationLinks')),
        ]);
    }
}
