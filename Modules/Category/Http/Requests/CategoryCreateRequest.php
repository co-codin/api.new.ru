<?php

namespace Modules\Category\Http\Requests;

use App\Enums\Status;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

class CategoryCreateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'parent_id' => 'sometimes|nullable|integer|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug',
            'product_name' => 'sometimes|nullable|string|max:255',
            'full_description' => 'sometimes|nullable|string|max:255',
            'status' => [
                'required',
                new EnumValue(Status::class, false),
            ],
            'is_hidden_in_parents' => 'sometimes|boolean',
            'is_in_home' => 'sometimes|boolean',
            'image' => [
                'required_unless:parent_id,null',
                'nullable',
                'image',
                'max:255',
            ],
        ];
    }
}
