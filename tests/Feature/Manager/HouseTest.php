<?php

namespace Tests\Feature\Manager;

use Tests\TestCase;
use App\Models\Manager;
use App\Models\House;
use Database\Seeders\EstateManagerSeeder;
use Laravel\Passport\Passport;
use Database\Seeders\HouseSeeder;
use Database\Seeders\EstateSeeder;

class HouseTest extends TestCase
{

    public function testUserCanGetAllHouses()
    {
        $this->seed([
            EstateSeeder::class,
            EstateManagerSeeder::class,
        ]);

        $manager = Manager::all()->random();

        Passport::actingAs(
            $manager,
            ['manager'],
            "manager-api"
        );

        $response = $this->getJson(route('manager.houses.index'));
        $response->assertStatus(200);
    }


    public function testUserCanGetHouse()
    {
        $this->seed([
            EstateSeeder::class,
            EstateManagerSeeder::class,
            HouseSeeder::class,
        ]);

        $manager = Manager::all()->random();

        Passport::actingAs(
            $manager,
            ['manager'],
            "manager-api"
        );

        $house = House::all()->random();

        $response = $this->getJson(route('manager.houses.show', $house->id));
        $response->assertStatus(200);
    }


    public function testUserCanCreateHouse()
    {
        $this->seed([
            EstateSeeder::class,
            EstateManagerSeeder::class,
        ]);

        $manager = Manager::all()->random();

        Passport::actingAs(
            $manager,
            ['manager'],
            "manager-api"
        );

        $estate = $manager->estates->random();

        $attributes = array_merge(
            House::factory()->make()->toArray(),
            ['estate_id' => $estate->id]
        );

        $response = $this->postJson(route('manager.houses.store'), $attributes);

        $response->assertStatus(201);

        $this->assertDatabaseHas('houses', $attributes);
    }


    public function testUserCanUpdateHouse()
    {
        $this->seed([
            EstateSeeder::class,
            EstateManagerSeeder::class,
            HouseSeeder::class,
        ]);

        $manager = Manager::all()->random();

        Passport::actingAs(
            $manager,
            ['manager'],
            "manager-api"
        );

        $estate = $manager->estates->random();

        $house = $estate->houses->random();

        $attributes = array_merge(
            House::factory()->make()->toArray(),
            ['estate_id' => $estate->id]
        );

        $response = $this->putJson(route('manager.houses.update', $house->id), $attributes);

        $response->assertStatus(200);

        $this->assertDatabaseHas('houses', $attributes);
    }

    public function testUserCanDeleteHouse()
    {
        $this->seed([
            EstateSeeder::class,
            EstateManagerSeeder::class,
            HouseSeeder::class,
        ]);

        $manager = Manager::all()->random();

        Passport::actingAs(
            $manager,
            ['manager'],
            "manager-api"
        );

        $estate = $manager->estates->random();

        $house = $estate->houses->random();

        $response = $this->deleteJson(route('manager.houses.destroy', $house->id));

        $response->assertStatus(200);

        $this->assertDatabaseMissing('houses', $house->toArray());
    }
}
