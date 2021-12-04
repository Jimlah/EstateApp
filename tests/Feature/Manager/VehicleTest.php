<?php

namespace Tests\Feature\Manager;

use Tests\TestCase;
use App\Models\User;
use App\Models\Manager;
use Laravel\Passport\Passport;
use Database\Seeders\HouseSeeder;
use Database\Seeders\EstateSeeder;
use Database\Seeders\VehicleSeeder;
use Database\Seeders\UserHouseSeeder;
use Database\Seeders\EstateManagerSeeder;

class VehicleTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testManagerGetUsersVehicle()
    {
        $this->seed([
            EstateSeeder::class,
            EstateManagerSeeder::class,
            HouseSeeder::class,
            UserHouseSeeder::class,
            VehicleSeeder::class
        ]);

        $user = Manager::all()->random();

        Passport::actingAs($user, ['manager'], 'manager-api');

        $response = $this->getJson(route('manager.vehicles'));
        $response->assertStatus(200);
    }
}
