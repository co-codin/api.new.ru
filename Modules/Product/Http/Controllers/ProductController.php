<?php


namespace Modules\Product\Http\Controllers;


use App\Http\Controllers\Controller;
use Modules\Product\Http\Resources\ProductResource;
use Modules\Product\Models\Product;
use Modules\Product\Repositories\ProductRepository;

class ProductController extends Controller
{
    public function __construct(
        protected ProductRepository $productRepository
    ){}

    public function index()
    {
        $this->authorize('viewAny', Product::class);

        $products = $this->productRepository->jsonPaginate();

        return ProductResource::collection($products);
    }

    public function show(int $product)
    {
        $product = $this->productRepository->find($product);

        $this->authorize('view', $product);

        return new ProductResource($product);
    }
}
