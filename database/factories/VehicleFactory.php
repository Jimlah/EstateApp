<?php

namespace Database\Factories;

use Faker\Provider\Fakecar;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $this->faker->addProvider(new Fakecar($this->faker));
        return [
            'name' => $this->faker->vehicle,
            'model' => $this->faker->vehicleModel,
            'color' => $this->faker->vehicleColor,
            'license_plate' => $this->faker->vehicleRegistration,
            'type' => $this->faker->vehicleType,
         ];
    }
}
