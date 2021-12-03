<?php

namespace Database\Factories;

use App\Models\Manager;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Database\Eloquent\Factories\Factory;

class VisitorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'sent_by' => User::class,
            'approved' => $this->faker->boolean,
            'visited_at' => $this->faker->dateTime,
            'expired_at' => $this->faker->dateTime,
        ];
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function sentByManager()
    {
        return $this->state(function () {
            return [
                'sent_by' => Manager::class,
                'approved' => $this->faker->boolean,
            ];
        });
    }

    public function configure()
    {
        return $this->afterMaking(function (Visitor $visitor) {
            if ($visitor->expired_at !== null && $visitor->expired_at < $visitor->visited_at) {
                $visitor->expired_at = $visitor->visited_at;
            }
        })->afterCreating(function (Visitor $visitor) {
            if ($visitor->expired_at !== null && $visitor->expired_at < $visitor->visited_at) {
                $visitor->expired_at = $visitor->visited_at;
                $visitor->save();
            }
        });
    }
}
