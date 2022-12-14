<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Product\Http\Resources\ProductPageResource;
use Modules\Product\Repositories\Criteria\ProductPageCriteria;
use Modules\Product\Repositories\ProductRepository;

class ProductPageController extends Controller
{
    public function __construct(
        protected ProductRepository $productRepository
    ){
        $this->productRepository
            ->resetCriteria()
            ->pushCriteria(ProductPageCriteria::class);
    }

     public function show(int $product)
     {
        $product = $this->productRepository
            ->scopeQuery(function ($query) {
                return $query
                    ->visible()
                    ->hasActiveVariation()
                    ->withMainVariation()
                    ;
            })
            ->find($product);

         $product->properties = $product->properties->map(function($property) {
             return array_merge($property->toArray(), [
                 'fieldValues' => $property->pivot->fieldValues->toArray()
             ]);
         });

        return new ProductPageResource($product);
     }
}
