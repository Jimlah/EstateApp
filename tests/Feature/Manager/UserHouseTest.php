<?php

namespace Tests\Feature\Manager;

use Tests\TestCase;
use App\Models\Estate;
use App\Models\EstateManager;
use App\Models\Manager;
use Database\Seeders\EstateSeeder;
use Database\Seeders\EstateManagerSeeder;
use Database\Seeders\HouseSeeder;
use Database\Seeders\UserHouseSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;

class UserHouseTest extends TestCase
{
    public function testGetAllUserInAHouse()
    {
        $this->seed([
            EstateSeeder::class ,
            EstateManagerSeeder::class,
            HouseSeeder::class,
            UserHouseSeeder::class
        ]);

        $manager = Manager::all()->random();

        Passport::actingAs($manager, ['manager'], 'manager-api');

        $house = $manager->estates->random()->houses->random();

        $response = $this->getJson(route('manager.houses.users.index',[$house->id]));
        $response->assertStatus(200);
    }
}
