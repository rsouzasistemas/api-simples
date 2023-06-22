<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UsersApiTest extends TestCase
{
    use RefreshDatabase;

    // Test return from a list of users
    public function test_get_all_users()
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );

        $users = User::factory(3)->create();
        $response = $this->get('/api/users');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    // Single user test return
    public function test_get_unique_user()
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );

        $user = User::factory()->create();
        $response = $this->get('/api/users/' . $user->id);

        $response->assertStatus(200);
        $response->assertJson(function (AssertableJson $json) use($user) {
            $json->whereAll([
                'data.name' => strtoupper($user->name),
                'data.email' => $user->email
            ]);
        });
    }

    // Test return of creating a new user
    public function test_post_json_create_user()
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );

        $user = [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => \Illuminate\Support\Str::random(10),
        ];

        $response = $this->postJson('/api/users', $user);
        $response->assertStatus(201);

        $response->assertJson(function (AssertableJson $json) use($user) {
            $json->whereAll([
                'data.name' => strtoupper($user['name']),
                'data.email' => $user['email']
            ]);
        });
    }

    // Test return of updating a user
    public function test_put_json_update_user ()
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );

        $user = User::factory()->create();

        $updateUser = [
            'name' => 'New Name',
            'email' => 'new.email@mail.com'
        ];

        $response = $this->putJson('/api/users/' . $user->id, $updateUser);
        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) use($updateUser) {
            $json->whereAll([
                'data.name' => strtoupper($updateUser['name']),
                'data.email' => $updateUser['email']
            ]);
        });
    }

    // Test return of deleting a user
    public function test_delete_user()
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );

        $user = User::factory()->create();
        $response = $this->deleteJson('/api/users/' . $user->id);
        $response->assertStatus(204);
    }

    // Test return of fetching a non-existent record
    public function test_return_404_if_no_record_found_with_passed_id()
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );

        $response = $this->get('/api/users/999');
        $response->assertStatus(404);
    }

    // Return from testing public access to a protected route
    public function test_not_allow_public_access_to_users()
    {
        $response = $this->get('/api/users');
        $response->assertStatus(302);
    }
}
