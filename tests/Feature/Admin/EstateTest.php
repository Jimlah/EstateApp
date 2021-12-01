<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use App\Models\Estate;
use App\Models\Manager;
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
    public function testAdminCanCreateNewEstate()
    {
        $this->withoutExceptionHandling();
        $attributes = array_merge(
            Manager::factory()->make()->toArray(),
            Estate::factory()->make()->toArray()
        );

        $admin =  Admin::factory()->create();
        Passport::actingAs($admin, ['admin'], 'admin-api');

        $response = $this->postJson(route('admin.estates.store'), $attributes);
        $response->assertStatus(201);
    }
}
