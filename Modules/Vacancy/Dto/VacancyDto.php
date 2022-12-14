<?php


namespace Modules\Vacancy\Dto;


use App\Dto\BaseDto;

class VacancyDto extends BaseDto
{
    public ?string $name;

    public ?string $slug;

    public ?string $short_description;

    public ?int $status;

    public ?string $experience;

    public ?string $timetable;

    public ?string $occupation;

    public ?string $duty;

    public ?string $requirement;

    public ?string $condition;
}
