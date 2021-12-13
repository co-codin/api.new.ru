<?php

namespace Modules\Qna\Http\Requests;

use App\Http\RequestFilters\SanitizesInput;
use App\Http\Requests\BaseFormRequest;

class QuestionCreateRequest extends BaseFormRequest
{
    use SanitizesInput;

    public function filters(): array
    {
        return [
            'product_id' => 'nullable-cast:integer',
        ];
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|int|exists:products,id',
            'text' => 'sometimes|nullable|string',
        ];
    }

    public function attributes(): array
    {
        return [
            'product_id' => 'Товар',
            'text' => 'Комментарий',
        ];
    }
}
