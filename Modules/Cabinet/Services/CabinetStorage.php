<?php

namespace Modules\Cabinet\Services;

use App\Services\File\ImageUploader;
use Modules\Cabinet\Dto\CabinetDto;
use Modules\Cabinet\Models\Cabinet;

class CabinetStorage
{
    public function __construct(protected ImageUploader $imageUploader) {}

    public function store(CabinetDto $cabinetDto)
    {
        $attributes = $cabinetDto->toArray();

        return Cabinet::query()->create($attributes);
    }

    public function update(Cabinet $cabinet, CabinetDto $cabinetDto)
    {
        $attributes = $cabinetDto->toArray();

        if ($cabinetDto->categories) {
            foreach ($cabinetDto->categories as $category) {
                $cabinet->categories()->attach($category->id, [
                    'name' => $category->name,
                    'count' => $category->count,
                    'price' => $category->price ?: null,
                    'position' => $category->position ?: null,
                ]);
            }
        }

        if (!$cabinet->update($attributes)) {
            throw new \LogicException('can not update cabinet');
        }

        return $cabinet;
    }

    public function destroy(Cabinet $cabinet)
    {
        if (!$cabinet->delete()) {
            throw new \LogicException('can not delete cabinet');
        }
    }
}
