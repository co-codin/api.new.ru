<?php


namespace Modules\Search\Filters;


use Modules\Search\Contracts\Filter;

class TermsFilter implements Filter
{
    protected $field;
    protected $value;

    public function __construct(string $field, $value)
    {
        $this->field = $field;
        $this->value = $value;
    }

    public function toFilter(): array
    {
        return [
            'terms' => [
                $this->field => $this->value,
            ],
        ];
    }
}
