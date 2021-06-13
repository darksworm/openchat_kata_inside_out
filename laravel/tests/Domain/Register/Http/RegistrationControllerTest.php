<?php

namespace Tests\Domain\Register\Http;

use App\Domain\Register\DuplicateUsernameException;
use App\Domain\Register\Http\RegisterController;
use App\Domain\Register\Http\RegisterRequest;
use App\Domain\Register\RegisterService;
use App\Models\User;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class RegistrationControllerTest extends TestCase
{
    private RegisterController $controller;
    private MockObject $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = $this->createMock(RegisterService::class);
        $this->controller = new RegisterController($this->service);
    }

    public function
    test_returns400_when_username_already_registered()
    {
        $request = $this->newRequest();

        $this->service->expects($this->once())
            ->method('register')
            ->with('someUsername', 'some password', 'about my turtles')
            ->willThrowException(new DuplicateUsernameException());

        $response = $this->controller->registerUser($request);

        $this->assertEquals($response->getStatusCode(), 400);
        $this->assertEquals($response->getContent(), "Username already in use");
    }

    public function
    test_returns201_when_registration_successful()
    {
        $request = $this->newRequest();

        $this->service->expects($this->once())
            ->method('register')
            ->with('someUsername', 'some password', 'about my turtles');

        $response = $this->controller->registerUser($request);

        $this->assertEquals($response->getStatusCode(), 201);
    }

    public function
    test_returns_transformed_user_when_registration_successful()
    {
        $request = $this->newRequest();

        $user = new User;
        $user->username = 'someUsername';
        $user->password = 'some password';
        $user->about = 'about my turtles';
        $user->user_id = '123';

        $this->service->expects($this->once())
            ->method('register')
            ->with('someUsername', 'some password', 'about my turtles')
            ->willReturn($user);

        $response = $this->controller->registerUser($request);

        $this->assertJson($response->getContent());
        $this->assertEquals([
            'id' => '123',
            'username' => 'someUsername',
            'about' => 'about my turtles'
        ], json_decode($response->getContent(), true));
    }

    private function newRequest(): MockObject|RegisterRequest
    {
        $request = $this->createMock(RegisterRequest::class);

        $request->expects($this->once())
            ->method('getUsername')
            ->willReturn('someUsername');

        $request->expects($this->once())
            ->method('getPassword')
            ->willReturn('some password');

        $request->expects($this->once())
            ->method('getAbout')
            ->willReturn('about my turtles');

        return $request;
    }
}
