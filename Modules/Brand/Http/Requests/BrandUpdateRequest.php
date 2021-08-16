<?php

namespace Modules\Brand\Http\Requests;

use App\Enums\Status;
use BenSampo\Enum\Rules\EnumValue;
use App\Http\Requests\BaseFormRequest;

class BrandUpdateRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|nullable|string|max:255|unique:brands,slug,' . $this->route('brand'),
            'status' => [
                'sometimes',
                'required',
                new EnumValue(Status::class, false),
            ],
            'is_in_home' => 'sometimes|boolean',
            'is_image_changed' => 'sometimes|boolean',
            'image' => 'sometimes|exclude_unless:is_image_changed,true|nullable|image',
            'country' => 'sometimes|nullable|string|max:255',
            'website' => 'sometimes|nullable|string|url|max:255',
            'short_description' => 'sometimes|nullable|string',
            'full_description' => 'sometimes|nullable|string',
            'position' => 'sometimes|nullable|integer',
            'assigned_by_id' => 'sometimes|nullable|integer',
        ];
    }
}
