<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Passport\Passport;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserCanLogin()
    {

        $user = User::factory()->create();

        $response = $this->postJson(route('user.login'), [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertStatus(200);
        $response->assertJson(function (AssertableJson $json) {
            $json->has('token')
                ->has('user')
                ->has('message')
                ->has('status')
                ->etc();
        });
    }

    public function testUserCanLogOut()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();

        Passport::actingAs($user, ['user'], 'user-api');

        $response = $this->getJson(route('user.user.logout'));

        $response->assertStatus(200);
        $response->assertJson(function (AssertableJson $json) {
            $json->has('message')
                ->has('status')
                ->etc();
        });
    }
}
