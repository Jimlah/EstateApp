<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use App\Models\User;
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
    public function testAdminCanGetAllUser()
    {
        $this->seed([
            EstateSeeder::class,
            EstateManagerSeeder::class,
            HouseSeeder::class,
            UserHouseSeeder::class
        ]);

        $user = User::where('is_admin', true)->get()->random();

        Passport::actingAs($user, ['user'], 'user-api');

        $response = $this->getJson(route('user.users.index'));
        $response->assertStatus(200);
        $response->assertJson(function (AssertableJson $json) {
            $json->has('data')
                ->etc();
        });
    }

    public function testAdminCanAttachUserToHouse()
    {
        $this->seed([
            EstateSeeder::class,
            EstateManagerSeeder::class,
            HouseSeeder::class,
            UserHouseSeeder::class
        ]);

        $user = User::where('is_admin', true)->get()->random();
        $house = $user->houses->random();

        Passport::actingAs($user, ['user'], 'user-api');

        $attributes = array_merge(User::factory()->make()->toArray(), ['house_id' => $house->id]);

        $response = $this->postJson(route('user.users.store', $attributes));
        $response->assertStatus(201);

        $user = User::all()->last();
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'first_name' => $attributes['first_name'],
            'last_name' => $attributes['last_name'],
            'email' => $attributes['email'],
        ]);

        $this->assertDatabaseHas('user_houses', [
            'user_id' => $user->id,
            'house_id' => $house->id
        ]);
    }

    public function testAdminCanGetASingleUser()
    {
        $this->seed([
            EstateSeeder::class,
            EstateManagerSeeder::class,
            HouseSeeder::class,
            UserHouseSeeder::class
        ]);

        $user = User::where('is_admin', true)->get()->random();

        Passport::actingAs($user, ['user'], 'user-api');

        $house = $user->houses->random();
        $user = $house->users->except($user->id)->random();

        $response = $this->getJson(route('user.users.show', $user->id));
        $response->assertStatus(200);
        $response->assertJson(function (AssertableJson $json) {
            $json->has('id')
                ->etc();
        });
    }

    public function testAdminCanUpdateASingleUser()
    {
        $this->seed([
            EstateSeeder::class,
            EstateManagerSeeder::class,
            HouseSeeder::class,
            UserHouseSeeder::class
        ]);

        $user = User::where('is_admin', true)->get()->random();

        Passport::actingAs($user, ['user'], 'user-api');

        $house = $user->houses->random();
        $user = $house->users->except($user->id)->random();

        $attributes = array_merge(User::factory()->make()->toArray(), ['first_name' => 'Abdullahi']);

        $response = $this->putJson(route('user.users.update', $user->id), $attributes);
        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'first_name' => $attributes['first_name'],
            'last_name' => $attributes['last_name'],
            'email' => $attributes['email'],
        ]);
    }

    public function testAdminCanDetachUserFromHouse()
    {
        $this->seed([
            EstateSeeder::class,
            EstateManagerSeeder::class,
            HouseSeeder::class,
            UserHouseSeeder::class
        ]);

        $user = User::where('is_admin', true)->get()->random();
        $house = $user->houses->random();

        Passport::actingAs($user, ['user'], 'user-api');

        $user = $house->users->except($user->id)->random();

        $response = $this->deleteJson(route('user.users.destroy', $user->id), ['house_id' => $house->id]);
        $response->assertStatus(200);

        $this->assertDatabaseMissing('user_houses', [
            'user_id' => $user->id,
            'house_id' => $house->id
        ]);
    }
}
