<?php

namespace Modules\Product\Services;

use App\Services\File\ImageUploader;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Product\Dto\ProductDto;
use Modules\Product\Models\Product;

class ProductStorage
{
    public function __construct(protected ImageUploader $imageUploader) {}

    public function store(ProductDto $productDto)
    {
        $attributes = $productDto->toArray();
        $attributes['image'] = $this->imageUploader->upload($productDto->image);

        if (Arr::exists($attributes, 'documents')) {
            $product = $this->createWithDocuments($attributes);
        } else {
            $product = Product::query()->create($attributes);
        }

        $product->categories()->sync(
            collect($productDto->categories)
                ->keyBy('id')
                ->map(fn($item) => Arr::except($item, 'id'))
                ->toArray()
        );

        $product->productVariants()->create([
            'name' => $product->brand->name . ' ' . $product->name
        ]);

        return $product;
    }

    public function update(Product $product, ProductDto $productDto)
    {
        $attributes = $productDto->toArray();

        if ($productDto->image) {
            $attributes['image'] = $this->imageUploader->upload($productDto->image);
        }

        // TODO need to discuss
//        if (Arr::exists($attributes, 'documents')) {
//            $this->updateWithDocuments($product, $attributes);
//        }

        if ($productDto->categories) {
            $product->categories()->detach();
            $product->categories()->sync(
                collect($productDto->categories)
                    ->keyBy('id')
                    ->map(fn($item) => Arr::except($item, 'id'))
                    ->toArray()
            );
        }

        if (!$product->update($attributes)) {
            throw new \LogicException('can not update product.');
        }

        return $product;
    }

    protected function updateWithDocuments($product, array $attributes)
    {

    }

    protected function createWithDocuments(array $attributes)
    {
        $attributes['documents'] = collect($attributes['documents'])->map(function ($document) {
            if (Arr::exists($document, 'file')) {
                $file = $document['file'];
                $fileName = Str::uuid();
                $extension = $file->getClientOriginalExtension();

                Storage::disk('public')->put($path = "documents/{$fileName}.{$extension}", $file);

                $document['file'] = $path;
            }
            return $document;
        })->toArray();

        $product = Product::query()->create($attributes);

        return $product;
    }
}
