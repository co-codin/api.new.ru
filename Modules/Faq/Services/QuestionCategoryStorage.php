<?php


namespace Modules\Faq\Services;


use Modules\Faq\Dto\QuestionCategoryDto;
use Modules\Faq\Models\QuestionCategory;

class QuestionCategoryStorage
{
    public function store(QuestionCategoryDto $questionCategoryDto)
    {
        $questionCategory = new QuestionCategory($questionCategoryDto->toArray());

        if (!$questionCategory->save()) {
            throw new \LogicException('can not create question category.');
        }

        return $questionCategory;
    }

    public function update(QuestionCategory $questionCategory, QuestionCategoryDto $questionCategoryDto)
    {
        if (!$questionCategory->update($questionCategoryDto->toArray())) {
            throw new \LogicException('can not update question category.');
        }

        return $questionCategory;
    }

    public function delete(QuestionCategory $questionCategory)
    {
        if (!$questionCategory->delete()) {
            throw new \LogicException('can not delete question category.');
        }
    }

    public function sort(array $categories)
    {
        foreach ($categories as $category) {
            QuestionCategory::query()
                ->where('id', $category['id'])
                ->update(['position' => $category['position']]);
        }
    }
}
