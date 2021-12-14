<?php

namespace Modules\Cabinet\Http\Requests;

use App\Enums\DocumentSourceEnum;
use App\Enums\DocumentTypeEnum;
use App\Http\Requests\BaseFormRequest;
use BenSampo\Enum\Rules\EnumValue;

class CabinetDocumentUpdateRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'documents' => 'required|array',
            'documents.*.group_name' => 'required|string|max:255',
            'documents.*.docs.*.name' => 'required|string|max:255',
            'documents.*.docs.*.type' => [
                'required',
                'integer',
                new EnumValue(DocumentTypeEnum::class, false)
            ],
            'documents.*.docs.*.source' => [
                'required',
                'integer',
                new EnumValue(DocumentSourceEnum::class, false)
            ],
            'documents.*.docs.*.file' => 'required_if:documents.*.source,', DocumentSourceEnum::FILE . '|file',
            'documents.*.docs.*.link' => 'required_if:documents.*.source,' . DocumentSourceEnum::LINK . '|string',
        ];
    }
}