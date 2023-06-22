<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LoginApiTest extends TestCase
{
    use RefreshDatabase;

    // Test return of generate a new user token
    public function test_post_json_token_generate()
    {
        $user = User::factory()->create();

        $auth = [
            'email' => $user->email,
            'password' => 'password'
        ];

        $response = $this->postJson('/api/login', $auth);
        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                'token'
            ]
        ]);
    }

    // Test return of deleting a user token
    public function test_delete_user_token()
    {
        $user = User::factory()->create();

        $auth = [
            'email' => $user->email,
            'password' => 'password'
        ];

        $response = $this->postJson('/api/login', $auth);
        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                'token'
            ]
        ]);

        $token = $response;

        Sanctum::actingAs(
            User::factory()->create(),
        );

        $response = $this->withHeaders(
            [
                'accept' => 'Application/json',
                'Authorization' => 'Bearer ' . $token['data']['token'],
            ]
        )->delete('/api/logout');
    }
}
