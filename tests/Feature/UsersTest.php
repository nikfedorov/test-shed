<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use App\User;

class UsersTest extends TestCase
{
    public function test_obtain_users_list()
    {
        // arrange
        $user = factory(User::class, 9)->create();

        // act
        $response = $this
            ->withHeaders(['Authorization' => 'Bearer '. $this->authenticate()])
            ->json(
                'GET',
                route('api.users.index')
            );

        // assert
        $response->assertStatus(200);

        $response->assertJsonCount(10);
    }

    public function test_create_new_user()
    {
        // act
        $response = $this
            ->withHeaders(['Authorization' => 'Bearer '. $this->authenticate()])
            ->json(
                'POST',
                route('api.users.create'),
                [
                    'email' => 'test-created@gmail.com',
                    'name' => 'Test Created',
                    'password' => 'secretsecret'
                ]
            );

        // assert
        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'email' => 'test-created@gmail.com'
        ]);
    }

    public function test_update_existing_user()
    {
        // arrange
        $user = factory(User::class)->create();

        // act
        $response = $this
            ->withHeaders(['Authorization' => 'Bearer '. $this->authenticate()])
            ->json(
                'PUT',
                route('api.users.update', $user->id),
                [
                    'email' => 'test-updated@gmail.com',
                    'name' => 'Test Updated',
                    'password' => 'secretsecret'
                ]
            );

        // assert
        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => 'test-updated@gmail.com',
            'name' => 'Test Updated',
        ]);
    }

    public function test_delete_existing_user()
    {
        // arrange
        $user = factory(User::class)->create();

        // act
        $response = $this
            ->withHeaders(['Authorization' => 'Bearer '. $this->authenticate()])
            ->json(
                'DELETE',
                route('api.users.delete', $user->id)
            );

        // assert
        $response->assertStatus(200);

        $this->assertDatabaseMissing('users', [
            'id' => $user->id
        ]);
    }
}
