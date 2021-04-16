<?php
namespace Modules\Property\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Property\Enums\PropertyType;

class PropertyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Property\Models\Property::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'type' => PropertyType::getRandomValue(),
        ];
    }
}

