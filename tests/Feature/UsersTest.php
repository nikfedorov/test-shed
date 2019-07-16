<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use App\User;
use Illuminate\Support\Facades\Hash;

class UsersTest extends TestCase
{
    public function test_obtain_users_list()
    {
        // arrange
        $user = factory(User::class, 9)->create();

        // act
        $response = $this->prepareRequest()
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
        $response = $this->prepareRequest()
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
        $response = $this->prepareRequest()
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

    public function test_update_existing_users_email_only()
    {
        // arrange
        $user = factory(User::class)->create();

        // act
        $response = $this->prepareRequest()
            ->json(
                'PUT',
                route('api.users.update', $user->id),
                [
                    'email' => 'test-updated@gmail.com'
                ]
            );

        // assert
        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => 'test-updated@gmail.com',
            'name' => $user->name
        ]);
    }

    public function test_update_existing_users_name_only()
    {
        // arrange
        $user = factory(User::class)->create();

        // act
        $response = $this->prepareRequest()
            ->json(
                'PUT',
                route('api.users.update', $user->id),
                [
                    'name' => 'Test Updated'
                ]
            );

        // assert
        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => $user->email,
            'name' => 'Test Updated',
        ]);
    }

    public function test_update_existing_users_password_only()
    {
        // arrange
        $user = factory(User::class)->create();

        // act
        $response = $this->prepareRequest()
            ->json(
                'PUT',
                route('api.users.update', $user->id),
                [
                    'password' => 'password-updated'
                ]
            );

        // assert
        $response->assertStatus(200);

        $user = User::findOrFail($user->id);
        $this->assertTrue(Hash::check('password-updated', $user->password), 'Database password invalid');
    }

    public function test_delete_existing_user()
    {
        // arrange
        $user = factory(User::class)->create();

        // act
        $response = $this->prepareRequest()
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
