<?php

namespace Modules\Page\Database\factories;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Page\Models\Page;

class PageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Page\Models\Page::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(4),
            'slug' => $this->faker->slug,
            'full_description' => $this->faker->sentence(10),
            'status' => Status::getRandomValue(),
        ];
    }
}

