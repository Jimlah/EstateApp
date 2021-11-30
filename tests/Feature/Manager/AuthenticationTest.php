<?php

namespace Tests\Feature\Manager;

use Tests\TestCase;
use App\Models\Manager;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testManagerCanLogin()
    {

        $manager = Manager::factory()->create();

        $response = $this->postJson(route('manager.login'), [
            'email' => $manager->email,
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

    public function testManagerCanLogOut()
    {
        $this->withoutExceptionHandling();
        $manager = Manager::factory()->create();

        Passport::actingAs($manager, ['manager'], 'manager-api');

        $response = $this->getJson(route('manager.logout'));

        $response->assertStatus(200);
        $response->assertJson(function (AssertableJson $json) {
            $json->has('message')
                ->has('status')
                ->etc();
        });
    }
}
