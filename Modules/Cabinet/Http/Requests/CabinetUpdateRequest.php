<?php

namespace Modules\Cabinet\Http\Requests;

use App\Enums\Status;
use App\Http\Requests\BaseFormRequest;
use BenSampo\Enum\Rules\EnumValue;

class CabinetUpdateRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'category_id' => 'sometimes|required|integer|exists:categories,id',
            'name' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|nullable|string|max:255|regex:/^[a-z0-9_\-]*$/|unique:cabinets,slug,' . $this->route('cabinet'),
            'is_image_changed' => 'sometimes|boolean',
            'image' => 'sometimes|exclude_unless:is_image_changed,true,1|required|image',
            'full_description' => 'sometimes|required|string',
            'status' => [
                'sometimes',
                'required',
                new EnumValue(Status::class, false),
            ],
            'welcome_text' => 'sometimes|nullable|string',
            'view_num' => 'sometimes|nullable|integer',
            'requirements' => 'sometimes|nullable|array',
            'requirements.*.group_name' => 'required|string|max:255',
            'requirements.*.requirements.*.key' => 'required|string|max:255',
            'requirements.*.requirements.*.value' => 'required|string|max:255',
            'requirements.*.requirements.*.position' => 'sometimes|nullable|integer',
        ];
    }

    public function attributes()
    {
        return [
            'welcome_text' => 'Приветственный текст',
            'requirements' => 'Требования',
            'requirements.*.group_name' => 'Название группы',
            'requirements.*.requirements.*.key' => 'Название',
            'requirements.*.requirements.*.value' => 'Значение',
            'requirements.*.requirements.*.position' => 'Позиция',
        ];
    }
}
