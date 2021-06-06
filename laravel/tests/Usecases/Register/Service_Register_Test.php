<?php

namespace Tests\Usecases\Register;

use App\Usecases\HashPassword\PasswordHasher;
use App\Usecases\Register\DuplicateUsernameException;
use App\Usecases\Register\RegistrationService;
use App\Usecases\Register\UserRegistrationRepository;
use Tests\TestCase;

class Service_Register_Test extends TestCase
{
    private UserRegistrationRepository $userRepo;
    private RegistrationService $service;
    private PasswordHasher $hasher;

    public function setUp(): void
    {
        $this->userRepo = $this->createMock(UserRegistrationRepository::class);
        $this->hasher = $this->createMock(PasswordHasher::class);

        $this->service = new RegistrationService($this->userRepo, $this->hasher);
    }

    public function
    test_rethrows_duplicate_username_exception_from_repository()
    {
        $this->userRepo->expects($this->once())
            ->method('createUser')
            ->willThrowException(new DuplicateUsernameException);

        $this->expectException(DuplicateUsernameException::class);
        $this->service->register("username", "", "");
    }

    public function
    test_forwards_username_and_about_to_repository()
    {
        $this->userRepo->expects($this->once())
            ->method('createUser')
            ->with("username", $this->anything(), "about");

        $this->service->register("username", "password", "about");
    }

    public function
    test_does_not_forward_plain_password_to_repository()
    {
        $this->userRepo->expects($this->once())
            ->method('createUser')
            ->with(
                $this->anything(),
                $this->callback(fn($x) => $x != "password"),
                $this->anything()
            );

        $this->service->register("username", "password", "about");
    }

    public function
    test_forwards_hashed_password_from_password_hasher_to_repository()
    {
        $this->hasher->expects($this->once())
            ->method('hashForPassword')
            ->with("password")
            ->willReturn("some very distinct password hash");

        $this->userRepo->expects($this->once())
            ->method('createUser')
            ->with("username", "some very distinct password hash", "about");

        $this->service->register("username", "password", "about");
    }
}
