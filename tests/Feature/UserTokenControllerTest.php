<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTokenControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_user_token()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/sanctum/token', [
            'email' => $user->email,
            'password' => 'password',
            'device_name' => 'mobile'
        ]);

        $response->assertSuccessful();
        $response->assertHeader('content-type', 'application/json');
        $response->assertJsonStructure(['token']);
    }
}
