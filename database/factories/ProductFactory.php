<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nome' => $this->faker->isbn10,
            'valor' => $this->faker->numberBetween(0, 1000000) * 0.01,
            'estoque' => $this->faker->numberBetween(0, 1000)
        ];
    }
}
