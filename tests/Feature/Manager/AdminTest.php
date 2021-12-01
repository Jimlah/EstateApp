<?php

namespace Tests\Feature\Manager;

use App\Models\Manager;
use Database\Seeders\EstateManagerSeeder;
use Database\Seeders\EstateSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class AdminTest extends TestCase
{
    public function testUserCanCreateAdmin()
    {
        $this->seed(EstateSeeder::class);
        $manager = Manager::all()->random();
        Passport::actingAs(
            $manager,
            ['manager'],
            'manager-api'
        );

        $estate = $manager->estates->random();

        $attributes = array_merge(Manager::factory()->make()->toArray(), [
            'estate_id' => $estate->id,
        ]);

        $response = $this->postJson(route('manager.managers.store'), $attributes);
        $response->assertStatus(201);

        $this->assertDatabaseHas('managers', [
            'email' => $attributes['email'],
            'first_name' => $attributes['first_name'],
            'last_name' => $attributes['last_name'],
        ]);

        $this->assertDatabaseHas('estate_managers', [
            'estate_id' => $estate->id,
            'manager_id' => Manager::all()->last()->id
        ]);
    }

    public function testManagerCanGetAllHisEstateAdmin()
    {
        $this->seed([
            EstateSeeder::class,
            EstateManagerSeeder::class,
        ]);
        $manager = Manager::all()->random();
        Passport::actingAs(
            $manager,
            ['manager'],
            'manager-api'
        );

        $response = $this->getJson(route('manager.managers.index'));
        $response->assertStatus(200);
    }

    public function testManagerCanGetHisEstateAdmin()
    {
        $this->seed([
            EstateSeeder::class,
            EstateManagerSeeder::class,
        ]);
        $manager = Manager::all()->random();
        Passport::actingAs(
            $manager,
            ['manager'],
            'manager-api'
        );

        $response = $this->getJson(route('manager.managers.show', $manager->estates->random()->managers->random()->id));
        $response->assertStatus(200);
    }

    public function testManagerCanUpdateHisEstateAdmin()
    {
        $this->seed([
            EstateSeeder::class,
            EstateManagerSeeder::class,
        ]);
        $manager = Manager::all()->random();
        Passport::actingAs(
            $manager,
            ['manager'],
            'manager-api'
        );

        $attributes = Manager::factory()->make()->toArray();
        $manager = $manager->estates->random()->managers->random();

        $response = $this->putJson(route('manager.managers.update', $manager->id), $attributes);
        $response->assertStatus(200);

        $this->assertDatabaseHas('managers', [
            'id' => $manager->id,
            'email' => $attributes['email'],
            'first_name' => $attributes['first_name'],
            'last_name' => $attributes['last_name'],
        ]);
    }

    public function testManagerCanDeleteHisEstateAdmin()
    {
        $this->seed([
            EstateSeeder::class,
            EstateManagerSeeder::class,
        ]);
        $manager = Manager::all()->random();
        Passport::actingAs(
            $manager,
            ['manager'],
            'manager-api'
        );

        $manager = $manager->estates->random()->managers->random();

        $response = $this->deleteJson(route('manager.managers.destroy', $manager->id));
        $response->assertStatus(200);

        $this->assertDatabaseMissing('managers', [
            'id' => $manager->id,
        ]);
    }
}
