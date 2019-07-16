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

    /**
     * Create a token for authorized request
     *
     * @return string
     */
    public function authenticate()
    {
        $user = factory(User::class)->create([
            'email' => 'test@gmail.com',
            'password' => bcrypt('secret1234'),
        ]);

        $token = JWTAuth::fromUser($user);
        return $token;
    }

    /**
     * Create a request with prepared headers
     *
     * @return PHPUnit\Framework\Test
     */
    public function prepareRequest()
    {
        return $this->withHeaders([
            'Authorization' => 'Bearer '. $this->authenticate()
        ]);
    }
}
