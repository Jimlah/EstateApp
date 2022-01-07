<?php

namespace Tests\Feature\Manager;

use App\Models\Manager;
use Database\Seeders\EstateManagerSeeder;
use Database\Seeders\EstateSeeder;
use Database\Seeders\HouseSeeder;
use Database\Seeders\UserHouseSeeder;
use Database\Seeders\VehicleSeeder;
use Database\Seeders\VisitorSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class EstateTest extends TestCase
{

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->seed([
            EstateSeeder::class,
            EstateManagerSeeder::class,
            HouseSeeder::class,
            UserHouseSeeder::class,
            VisitorSeeder::class,
            VehicleSeeder::class
        ]);

        $manager = Manager::first();
        Passport::actingAs($manager, ['manager'], 'manager-api');

        $response = $this->get(route('manager.estates.index'));
        $response->assertStatus(200);
    }
}
