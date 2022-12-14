<?php


namespace Modules\Product\Services\Qna;


use Modules\Product\Models\ProductAnswer;
use Modules\Product\Dto\ProductAnswerDto;

class ProductAnswerStorage
{
    /**
     * @throws \Exception
     */
    public function store(ProductAnswerDto $answerDto): ProductAnswer
    {
        $answer = new ProductAnswer($answerDto->toArray());

        if (!$answer->save()) {
            throw new \Exception('Can not create Answer');
        }

        return $answer;
    }

    /**
     * @throws \Exception
     */
    public function update(ProductAnswer $answer, ProductAnswerDto $answerDto): ProductAnswer
    {
        if (!$answer->update($answerDto->toArray())) {
            throw new \Exception('Can not update Answer');
        }

        return $answer;
    }

    /**
     * @throws \Exception
     */
    public function delete(ProductAnswer $answer): void
    {
        if (!$answer->delete()) {
            throw new \Exception('Can not delete Answer');
        }
    }
}
