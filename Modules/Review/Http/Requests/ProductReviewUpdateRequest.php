<?php

namespace Modules\Review\Http\Requests;

use App\Http\RequestFilters\SanitizesInput;
use App\Http\Requests\BaseFormRequest;
use Modules\Review\Enums\ProductReviewStatus;

class ProductReviewUpdateRequest extends BaseFormRequest
{
    use SanitizesInput;

    public function filters(): array
    {
        return [
            'status' => 'nullable-cast:integer',
            'is_confirmed' => 'nullable-cast:bool',
        ];
    }

    public function rules(): array
    {
        return [
            'status' => 'required|integer|enum_value:' . ProductReviewStatus::class,
            'is_confirmed' => 'required|boolean',
        ];
    }
}