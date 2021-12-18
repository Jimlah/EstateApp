<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Manager;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class TokenValidationCheckTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_admin_token_is_valid()
    {

        $admin = Admin::factory()->create();

        Passport::actingAs($admin, ['admin'], 'admin-api');


        $response = $this->getJson(route('admin.validate-token'));

        $response->assertStatus(200);
    }


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_token_is_valid()
    {

        $user = User::factory()->create();

        Passport::actingAs($user, ['user'], 'user-api');


        $response = $this->getJson(route('user.validate-token'));

        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_manager_token_is_valid()
    {

        $manager = Manager::factory()->create();

        Passport::actingAs($manager, ['manager'], 'manager-api');


        $response = $this->getJson(route('manager.validate-token'));

        $response->assertStatus(200);
    }
}
