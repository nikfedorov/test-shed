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
}
