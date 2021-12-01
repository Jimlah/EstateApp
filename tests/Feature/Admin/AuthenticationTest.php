<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\Admin;
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
    public function testAdminCanLogin()
    {
        $admin = Admin::factory()->create();

        $response = $this->postJson(route('admin.login'), [
            'email' => $admin->email,
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

    public function testAdminCanLogOut()
    {
        $admin = Admin::factory()->create();

        Passport::actingAs($admin, ['admin'], 'admin-api');

        $response = $this->getJson(route('admin.logout'));

        $response->assertStatus(200);
        $response->assertJson(function (AssertableJson $json) {
            $json->has('message')
                ->has('status')
                ->etc();
        });
    }
}
