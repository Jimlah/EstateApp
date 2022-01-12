<?php

namespace Tests\Feature\Manager;

use Tests\TestCase;
use App\Models\Manager;
use Laravel\Passport\Passport;
use Database\Seeders\HouseSeeder;
use Database\Seeders\EstateSeeder;
use Database\Seeders\UserHouseSeeder;
use Database\Seeders\EstateManagerSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
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
            UserHouseSeeder::class
        ]);

        $manager = Manager::all()->random();

        Passport::actingAs($manager, ['manager'], 'manager-api');

        $response = $this->getJson(route('manager.users'));
        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) {
            $json->has('data')
                ->etc();
        });
    }
}
