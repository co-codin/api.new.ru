<?php


namespace Modules\Product\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Modules\Product\Dto\ProductDto;
use Modules\Product\Http\Requests\Admin\ProductCreateRequest;
use Modules\Product\Http\Requests\Admin\ProductUpdateRequest;
use Modules\Product\Http\Resources\ProductResource;
use Modules\Product\Repositories\ProductRepository;
use Modules\Product\Services\ProductStorage;

class ProductController extends Controller
{
    public function __construct(
        protected ProductStorage $productStorage,
        protected ProductRepository $productRepository
    ) {}

    public function store(ProductCreateRequest $request)
    {
        $productDto = ProductDto::fromFormRequest($request);

        if (!$productDto->assigned_by_id) {
            $productDto->assigned_by_id = auth('custom-token')->id();
        }

        $product = $this->productStorage->store($productDto);

        return new ProductResource($product);
    }

    public function update(int $product, ProductUpdateRequest $request)
    {
        $productModel = $this->productRepository->find($product);

        $productModel = $this->productStorage->update($productModel, ProductDto::fromFormRequest($request));

        return new ProductResource($productModel);
    }

    public function destroy(int $product)
    {
        $productModel = $this->productRepository->find($product);

        $this->productStorage->delete($productModel);

        return response()->noContent();
    }
}
