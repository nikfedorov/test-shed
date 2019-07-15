<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    public function authenticate()
    {
        $user = factory(User::class)->create([
            'email' => 'test@gmail.com',
            'password' => bcrypt('secret1234'),
        ]);

        $token = JWTAuth::fromUser($user);
        return $token;
    }
}
