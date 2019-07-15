<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use App\User;

class AuthTest extends TestCase
{
    public function test_register()
    {
        // act
        $response = $this->json(
            'POST',
            route('api.register'),
            [
                'email' => 'test@gmail.com',
                'name' => 'Test',
                'password' => 'secret1234',
                'password_confirmation' => 'secret1234',
            ]
        );

        // assert
        $response->assertStatus(200);

        $this->assertArrayHasKey('token', $response->json());

        $this->assertDatabaseHas('users', [
            'email' => 'test@gmail.com',
            'name' => 'Test'
        ]);
    }
}
