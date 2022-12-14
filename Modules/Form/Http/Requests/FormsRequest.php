<?php

namespace Modules\Form\Http\Requests;

use App\Helpers\ClientAuthHelper;
use Illuminate\Foundation\Http\FormRequest as FormRequestAlias;
use JetBrains\PhpStorm\ArrayShape;
use Modules\Form\Forms\Form;
use Modules\Form\Helpers\FormRequestHelper;

/**
 * Class FormsRequest
 * @package Modules\Form\Http\Requests
 */
class FormsRequest extends FormRequestAlias
{
    public function rules(): array
    {
        return $this->getForm()->rules();
    }

    public function attributes(): array
    {
        return $this->getForm()->attributeLabels();
    }

    public function messages(): array
    {
        return $this->getForm()->messages();
    }

    public function getForm(): Form
    {
        return app(FormRequestHelper::class)->getForm();
    }

    #[ArrayShape([
        'auth_name' => "string|null",
        'auth_phone' => "string|null",
        'auth_email' => "string|null",
        'auth_id' => "string|null",
    ])]
    public function getClientData(): array
    {
        return app(ClientAuthHelper::class)->getClientData();
    }
}
