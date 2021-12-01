<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EstateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company(),
            'address' => $this->faker->address(),
            'code' => $this->faker->word(),
            'logo' => $this->faker->imageUrl(),
        ];
    }
}
