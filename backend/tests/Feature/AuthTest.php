<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    private function withFrontend()
    {
        return $this->withHeader('Origin', 'http://localhost:3000');
    }

    public function test_user_can_register(): void
    {
        $response = $this->withFrontend()
                         ->postJson('/api/register', [
                             'name'                  => 'Test User',
                             'email'                 => 'test@example.com',
                             'password'              => 'password123',
                             'password_confirmation' => 'password123',
                         ]);

        $response->assertStatus(201)
                 ->assertJsonStructure(['user']);
    }

    public function test_user_can_login(): void
    {
        $user = User::factory()->create(['password' => bcrypt('password123')]);

        $response = $this->withFrontend()
                         ->postJson('/api/login', [
                             'email'    => $user->email,
                             'password' => 'password123',
                         ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['user']);
    }

    public function test_user_cannot_login_with_wrong_password(): void
    {
        $user = User::factory()->create(['password' => bcrypt('password123')]);

        $response = $this->postJson('/api/login', [
            'email'    => $user->email,
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(422);
    }

    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->withFrontend()
                         ->actingAs($user, 'sanctum')
                         ->postJson('/api/logout');

        $response->assertStatus(200);
    }

    public function test_register_requires_valid_email(): void
    {
        $response = $this->postJson('/api/register', [
            'name'                  => 'Test User',
            'email'                 => 'not-an-email',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(422);
    }
}
