<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use App\Models\User;
use App\Models\Visitor;
use Laravel\Passport\Passport;
use Database\Seeders\HouseSeeder;
use Database\Seeders\EstateSeeder;
use Database\Seeders\VisitorSeeder;
use Database\Seeders\UserHouseSeeder;
use Database\Seeders\EstateManagerSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
            VisitorSeeder::class
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserGetAllVisitor()
    {
        $user = User::all()->random();

        Passport::actingAs($user, ['user'], 'user-api');

        $response = $this->getJson(route('user.visitors.index'));

        $response->assertStatus(200);
        $response->assertJson(function (AssertableJson $json) {
            $json->has('data')
                ->etc();
        });
    }

    public function testUserGetVisitor()
    {
        $user = User::all()->random();

        Passport::actingAs($user, ['user'], 'user-api');

        $visitor = $user->visitors->random();

        $response = $this->getJson(route('user.visitors.show', $visitor->id));

        $response->assertStatus(200);
        $response->assertJson(function (AssertableJson $json) {
            $json->has('id')
                ->etc();
        });
    }

    public function testUserCanCreateAVisitor()
    {
        $user = User::all()->random();

        Passport::actingAs($user, ['user'], 'user-api');

        $estate = $user->houses->random()->estate;
        $attributes = array_merge(Visitor::factory()->make()->toArray(), [
            'estate_id' => $estate->id,
        ]);

        $response = $this->postJson(route('user.visitors.store'), $attributes);
        $response->assertStatus(201);

        $response->assertJson(function (AssertableJson $json) {
            $json->has('message')
                ->has('status')
                ->etc();
        });

        $this->assertDatabaseHas('visitors', [
            'first_name' => $attributes['first_name'],
            'last_name' => $attributes['last_name'],
            'phone' => $attributes['phone'],
            'email' => $attributes['email'],
            'address' => $attributes['address'],
        ]);
    }

    public function testUserCanUpdateAVisitor()
    {
        $user = User::all()->random();

        Passport::actingAs($user, ['user'], 'user-api');

        $visitor = $user->visitors->random();

        $attributes = Visitor::factory()->make()->toArray();
        $response = $this->putJson(route('user.visitors.update', $visitor->id), $attributes);
        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) {
            $json->has('message')
                ->has('status')
                ->etc();
        });

        $this->assertDatabaseHas('visitors', [
            'first_name' => $attributes['first_name'],
            'last_name' => $attributes['last_name'],
            'phone' => $attributes['phone'],
            'email' => $attributes['email'],
            'address' => $attributes['address'],
        ]);
    }

    public function testUserCanDeleteAVisitor()
    {
        $user = User::all()->random();

        Passport::actingAs($user, ['user'], 'user-api');

        $visitor = $user->visitors->random();

        $response = $this->deleteJson(route('user.visitors.destroy', $visitor->id));
        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) {
            $json->has('message')
                ->has('status')
                ->etc();
        });

        $this->assertDatabaseMissing('visitors', [
            'id' => $visitor->id
        ]);
    }
}
