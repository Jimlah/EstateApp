<?php

namespace Tests\Feature\Manager;

use App\Models\Manager;
use Tests\TestCase;
use App\Models\Visitor;
use Database\Seeders\HouseSeeder;
use Database\Seeders\EstateSeeder;
use Database\Seeders\VisitorSeeder;
use Database\Seeders\UserHouseSeeder;
use Database\Seeders\EstateManagerSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;

class VisitorTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([
            EstateSeeder::class,
            EstateManagerSeeder::class,
            HouseSeeder::class,
            UserHouseSeeder::class,
            VisitorSeeder::class,
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testManagerCanGetAllVisitor()
    {
        $manager = Manager::all()->random();
        Passport::actingAs($manager, ['manager'], 'manager-api');

        $response = $this->getJson(route('manager.visitors.index'));
        $response->assertStatus(200);
    }

    public function testManagerCanGetVisitor()
    {
        $manager = Manager::all()->random();
        Passport::actingAs($manager, ['manager'], 'manager-api');

        $visitor = Visitor::with('estate')->whereHas('estate', function ($query) use ($manager) {
            $query->whereIn('estate_id', $manager->estates->pluck('id'));
        })->get()->random();

        $response = $this->getJson(route('manager.visitors.show', $visitor->id));
        $response->assertStatus(200);
    }

    public function testManagerCanCreateVisitor()
    {
        $manager = Manager::all()->random();
        Passport::actingAs($manager, ['manager'], 'manager-api');

        $estate = $manager->estates->random();
        $user = $estate->houses->random()->users->random();

        $response = $this->postJson(
            route('manager.visitors.store'),
            Visitor::factory()->make([
                'user_id' => $user->id,
                'estate_id' => $estate->id,
            ])->toArray()
        );

        $response->assertStatus(201);
    }

    function testManagerCanUpdateVisitor()
    {
        $manager = Manager::all()->random();
        Passport::actingAs($manager, ['manager'], 'manager-api');

        $visitor = Visitor::with('estate')->whereHas('estate', function ($query) use ($manager) {
            $query->whereIn('estate_id', $manager->estates->pluck('id'));
        })->get()->random();

        $estate = $manager->estates->random();
        $user = $estate->houses->random()->users->random();

        $response = $this->putJson(
            route('manager.visitors.update', $visitor->id),
            Visitor::factory()->make([
                'user_id' => $user->id,
                'estate_id' => $estate->id,
            ])->toArray()
        );

        $response->assertStatus(200);
    }

    function testManagerCanDeleteVisitor()
    {
        $manager = Manager::all()->random();
        Passport::actingAs($manager, ['manager'], 'manager-api');

        $visitor = Visitor::with('estate')->whereHas('estate', function ($query) use ($manager) {
            $query->whereIn('estate_id', $manager->estates->pluck('id'));
        })->get()->random();

        $response = $this->deleteJson(
            route('manager.visitors.destroy', $visitor->id)
        );

        $response->assertStatus(200);
    }
}
