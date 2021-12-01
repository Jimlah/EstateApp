<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\Admin;
use App\Models\Estate;
use App\Models\Manager;
use Laravel\Passport\Passport;
use Database\Seeders\EstateSeeder;
use Illuminate\Testing\Fluent\AssertableJson;

class EstateTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAdminCanCreateNewEstate()
    {
        $attributes = array_merge(
            Manager::factory()->make()->toArray(),
            Estate::factory()->make()->toArray()
        );

        $admin =  Admin::factory()->create();
        Passport::actingAs($admin, ['admin'], 'admin-api');

        $response = $this->postJson(route('admin.estates.store'), $attributes);
        $response->assertStatus(201);
    }

    public function testAdminCanGetAllEstate()
    {
        $this->seed(EstateSeeder::class);
        $admin =  Admin::factory()->create();
        Passport::actingAs($admin, ['admin'], 'admin-api');

        $response = $this->getJson(route('admin.estates.index'));
        $response->assertStatus(200);
        $response->assertJson(
            fn (AssertableJson $json) =>
            $json->has('data')
                ->has('meta')
                ->has('links')
        );
    }


    public function testAdminCanGetEstateById()
    {
        $this->seed(EstateSeeder::class);
        $admin =  Admin::factory()->create();
        Passport::actingAs($admin, ['admin'], 'admin-api');

        $estate = Estate::all()->random();
        $response = $this->getJson(route('admin.estates.show', $estate->id));
        $response->assertStatus(200);
        $response->assertJson(
            fn (AssertableJson $json) =>
            $json->where('id', $estate->id)
                ->has('manager')
                ->etc()
        );
    }


    public function testAdminCanUpdateEstate()
    {
        $this->seed(EstateSeeder::class);
        $admin =  Admin::factory()->create();
        Passport::actingAs($admin, ['admin'], 'admin-api');

        $estate = Estate::all()->random();
        $attributes = array_merge(
            Manager::factory()->make()->toArray(),
            Estate::factory()->make()->toArray()
        );

        $response = $this->putJson(route('admin.estates.update', $estate->id), $attributes);
        $response->assertStatus(200);
    }


    public function testAdminCanDeleteEstate()
    {
        $this->seed(EstateSeeder::class);
        $admin =  Admin::factory()->create();
        Passport::actingAs($admin, ['admin'], 'admin-api');

        $estate = Estate::all()->random();
        $response = $this->deleteJson(route('admin.estates.destroy', $estate->id));
        $response->assertStatus(200);
    }
}
