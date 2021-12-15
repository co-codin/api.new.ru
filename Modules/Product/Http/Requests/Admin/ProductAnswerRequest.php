<?php

namespace Modules\Product\Http\Requests\Admin;

use App\Http\RequestFilters\SanitizesInput;
use App\Http\Requests\BaseFormRequest;

class ProductAnswerRequest extends BaseFormRequest
{
    use SanitizesInput;

    public function filters(): array
    {
        return [
            'product_question_id' => 'nullable-cast:integer',
        ];
    }

    public function rules(): array
    {
        return [
            'product_question_id' => 'required|int|exists:question,id',
            'text' => 'required|string',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'person' => 'sometimes|nullable|string|max:255',
            'created_at' => 'sometimes|nullable|string|min:4',
        ];
    }

    public function attributes(): array
    {
        return [
            'product_question_id' => 'Вопрос',
            'text' => 'Текст ответа',
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'person' => 'Название лица оставившего ответ',
            'created_at' => 'Дата создания',
        ];
    }
}
