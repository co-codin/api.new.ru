<?php


namespace Modules\News\Http\Requests;


use App\Enums\Status;
use BenSampo\Enum\Rules\EnumValue;
use App\Http\Requests\BaseFormRequest;

class NewsUpdateRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'short_description' => 'sometimes|required|string|max:900',
            'full_description' => 'sometimes|required|string',
            'status' => [
                'sometimes',
                'required',
                new EnumValue(Status::class, false),
            ],
            'slug' => 'sometimes|regex:/^[a-z0-9_\-]+$/|nullable|max:255|unique:news,slug,' . $this->route('news'),
            'is_image_changed' => 'sometimes|boolean',
            'image' => 'sometimes|exclude_unless:is_image_changed,true,1|required|string',
            'is_in_home' => 'sometimes|boolean',
            'published_at' => 'sometimes|required|date',
            'view_num' => 'sometimes|nullable|integer',
            'assigned_by_id' => 'sometimes|nullable|integer',
            'category' => 'string|nullable|max:255',
            'sources' => 'sometimes|nullable|array',
            'sources.*.source_name' => 'required|string|max:255',
            'sources.*.source_link' => 'required|string|max:255',
        ];
    }

    public function attributes()
    {
        return [
            'published_at' => 'Дата публикации',
            'category' => 'Рубрика',
        ];
    }
}
