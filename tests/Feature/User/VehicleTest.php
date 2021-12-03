<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use App\Models\User;
use App\Models\Vehicle;
use Laravel\Passport\Passport;
use Database\Seeders\HouseSeeder;
use Database\Seeders\EstateSeeder;
use Database\Seeders\VehicleSeeder;
use Database\Seeders\UserHouseSeeder;
use Database\Seeders\EstateManagerSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VehicleTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserCanGetHisOrHerAVehicles()
    {
        $this->seed([
            EstateSeeder::class,
            EstateManagerSeeder::class,
            HouseSeeder::class,
            UserHouseSeeder::class,
            VehicleSeeder::class
        ]);

        $user = User::all()->random();

        Passport::actingAs($user, ['user'], 'user-api');

        $response = $this->getJson(route('user.vehicles.index'));
        $response->assertStatus(200);
        $response->assertJson(function (AssertableJson $json) {
            $json->has('data')
                ->etc();
        });
    }

    public function testUserCanCreateVehicle()
    {
        $this->seed([
            EstateSeeder::class,
            EstateManagerSeeder::class,
            HouseSeeder::class,
            UserHouseSeeder::class,
            VehicleSeeder::class
        ]);

        $user = User::all()->random();

        Passport::actingAs($user, ['user'], 'user-api');

        $attributes = array_merge(Vehicle::factory()->make()->toArray());

        $response = $this->postJson(route('user.vehicles.store'), $attributes);

        $response->assertStatus(201);
        $response->assertJson(function (AssertableJson $json) {
            $json->has('message')
                ->has('status')
                ->etc();
        });

        $this->assertDatabaseHas('vehicles', $attributes);
    }

    public function testUserCanUpdateVehicle()
    {
        $this->seed([
            EstateSeeder::class,
            EstateManagerSeeder::class,
            HouseSeeder::class,
            UserHouseSeeder::class,
            VehicleSeeder::class
        ]);

        $user = User::all()->random();

        Passport::actingAs($user, ['user'], 'user-api');

        $vehicle = $user->vehicles->random();

        $attributes = array_merge(Vehicle::factory()->make()->toArray());

        $response = $this->putJson(route('user.vehicles.update', $vehicle->id), $attributes);

        $response->assertStatus(200);
        $response->assertJson(function (AssertableJson $json) {
            $json->has('message')
                ->has('status')
                ->etc();
        });

        $this->assertDatabaseHas('vehicles', $attributes);
    }

    public function testUserCanDeleteVehicle()
    {
        $this->seed([
            EstateSeeder::class,
            EstateManagerSeeder::class,
            HouseSeeder::class,
            UserHouseSeeder::class,
            VehicleSeeder::class
        ]);

        $user = User::all()->random();

        Passport::actingAs($user, ['user'], 'user-api');

        $vehicle = $user->vehicles->random();

        $response = $this->deleteJson(route('user.vehicles.destroy', $vehicle->id));

        $response->assertStatus(200);
        $response->assertJson(function (AssertableJson $json) {
            $json->has('message')
                ->has('status')
                ->etc();
        });

        $this->assertDatabaseMissing('vehicles', $vehicle->toArray());
    }
}
