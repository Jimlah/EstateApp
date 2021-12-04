<?php

namespace Tests\Feature\Manager;

use Tests\TestCase;
use App\Models\Manager;
use Laravel\Passport\Passport;
use Database\Seeders\HouseSeeder;
use Database\Seeders\EstateSeeder;
use Database\Seeders\VehicleSeeder;
use Database\Seeders\VisitorSeeder;
use Database\Seeders\UserHouseSeeder;
use Database\Seeders\EstateManagerSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testManagerDashboard()
    {
        $this->seed([
            EstateSeeder::class,
            EstateManagerSeeder::class,
            HouseSeeder::class,
            UserHouseSeeder::class,
            VisitorSeeder::class,
            VehicleSeeder::class
        ]);

        $user = Manager::all()->random();

        Passport::actingAs($user, ['manager'], 'manager-api');

        $response = $this->getJson(route('manager.dashboard'));
        $response->assertStatus(200);
    }
}
