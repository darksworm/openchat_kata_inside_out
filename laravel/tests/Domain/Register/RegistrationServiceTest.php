<?php

namespace Tests\Domain\Register;

use App\Domain\HashPassword\PasswordHasher;
use App\Domain\Register\DuplicateUsernameException;
use App\Domain\Register\RegisterRepository;
use App\Domain\Register\RegisterService;
use App\Models\User;
use Tests\TestCase;

class RegistrationServiceTest extends TestCase
{
    private RegisterRepository $userRepo;
    private RegisterService $service;
    private PasswordHasher $hasher;

    public function setUp(): void
    {
        $this->userRepo = $this->createMock(RegisterRepository::class);
        $this->hasher = $this->createMock(PasswordHasher::class);

        $this->service = new RegisterService($this->userRepo, $this->hasher);
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

    public function
    test_returns_created_user_model()
    {
        $this->hasher->expects($this->once())
            ->method('hashForPassword')
            ->with("password")
            ->willReturn("some very distinct password hash");

        $repoReturnUser = new User();

        $this->userRepo->expects($this->once())
            ->method('createUser')
            ->with("username", "some very distinct password hash", "about")
            ->willReturn($repoReturnUser);

        $registeredUser = $this->service->register("username", "password", "about");

        $this->assertEquals($repoReturnUser, $registeredUser);
    }
}
