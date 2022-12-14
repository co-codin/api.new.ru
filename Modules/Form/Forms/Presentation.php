<?php

namespace Modules\Form\Forms;

class Presentation extends Form
{
    public bool $sendToCrm = false;
    public bool $sendToBitrix = false;

    public function emails(): ?array
    {
        return config('services.mails.director');
    }

    public function title(): string
    {
        return 'Скачивание презентации';
    }

    public function messages(): array
    {
        return [
            'email.regex' => 'Поле :attribute должно содержать валидный email адрес.',
        ];
    }

    public function response(): array
    {
        return array_merge(parent::response(), [
            'url' => '/documents/presentation.pdf',
            'presentation' => 'Презентация Медэк Старз',
        ]);
    }

    public function ym(): ?string
    {
        return 'presentation_button_rush';
    }

    public function ga(): ?string
    {
        return 'presentation_button_rush';
    }
}
