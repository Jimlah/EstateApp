<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class HouseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'description' => $this->faker->sentence,
            'address' => $this->faker->address,
            'category' => $this->faker->randomElement(['apartment', 'house', 'villa']),
        ];
    }
}
