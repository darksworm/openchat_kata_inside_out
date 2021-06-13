<?php

namespace Tests\Domain\Register\Http;

use App\Domain\Register\Http\RegisterRequest;
use Tests\TestCase;

class RegistrationRequestTest extends TestCase
{
    private RegisterRequest $request;

    public function setUp(): void
    {
        parent::setUp();
        $this->request = new RegisterRequest([
            'username' => 'username',
            'password' => 'password',
            'about' => 'about'
        ]);
    }

    public function
    test_getters_return_correct_values()
    {
        $this->assertEquals('username', $this->request->getUsername());
        $this->assertEquals('password', $this->request->getPassword());
        $this->assertEquals('about', $this->request->getabout());
    }
}
