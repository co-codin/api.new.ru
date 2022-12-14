<?php

namespace Modules\Achievement\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class AchievementUpdateRequest extends BaseFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'is_image_changed' => 'sometimes|boolean',
            'image' => 'sometimes|exclude_unless:is_image_changed,true,1|required|image',
            'is_enabled' => 'sometimes|boolean',
        ];
    }
}
