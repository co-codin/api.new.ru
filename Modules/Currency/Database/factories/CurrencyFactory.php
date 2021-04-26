<?php

namespace Modules\Currency\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CurrencyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Currency\Models\Currency::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->currencyCode,
            'iso_code' => $this->faker->currencyCode,
            'rate' => $this->faker->randomFloat(2, 1, 3),
            'is_main' => false,
        ];
    }
}
