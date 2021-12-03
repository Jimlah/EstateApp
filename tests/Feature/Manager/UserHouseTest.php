<?php

namespace Tests\Feature\Manager;

use Tests\TestCase;
use App\Models\User;
use App\Models\Estate;
use App\Models\Manager;
use App\Models\EstateManager;
use Laravel\Passport\Passport;
use Database\Seeders\HouseSeeder;
use Database\Seeders\EstateSeeder;
use Database\Seeders\UserHouseSeeder;
use Database\Seeders\EstateManagerSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

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

        $response->assertJson(function(AssertableJson $json){
            $json->has('data')
                    ->etc();
        });
    }

    public function testManagerAddUserToAHouse()
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

        $attributes = User::factory()->make()->toArray();

        $response = $this->postJson(route('manager.houses.users.store',[$house->id]),$attributes);
        $response->assertStatus(201);

        $user = User::all()->last();

        $this->assertDatabaseHas('user_houses',[
            'user_id' => $user->id,
            'house_id' => $house->id,
            'is_admin' => true
        ]);

    }

    public function testManagerCanGetASingleUserInAHouse()
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

        $user = $house->users->random();

        $response = $this->getJson(route('manager.houses.users.show',[$house->id,$user->id]));
        $response->assertStatus(200);

        $response->assertJson(function(AssertableJson $json){
            $json->has('id')
                    ->etc();
        });
    }

    public function testManagerCanUpdateUserInAHouse()
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

        $user = $house->users->random();

        $attributes = User::factory()->make()->toArray();

        $response = $this->putJson(route('manager.houses.users.update',[$house->id,$user->id]),$attributes);
        $response->assertStatus(200);
    }

    public function testManagerCanDetachAUserFromAHouse()
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

        $user = $house->users->random();

        $response = $this->deleteJson(route('manager.houses.users.destroy',[$house->id,$user->id]));
        $response->assertStatus(200);

        $this->assertDatabaseMissing('user_houses',[
            'user_id' => $user->id,
            'house_id' => $house->id
        ]);
    }
}
