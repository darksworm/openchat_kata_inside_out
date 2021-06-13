<?php


namespace App\Domain\Register;


use App\Domain\HashPassword\CannotHashEmptyPasswordException;
use App\Domain\HashPassword\PasswordHasher;
use App\Models\User;

class RegisterService
{
    private RegisterRepository $repository;
    private PasswordHasher $passwordHasher;

    public function __construct(RegisterRepository $repository, PasswordHasher $passwordHasher)
    {
        $this->repository = $repository;
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @throws DuplicateUsernameException
     * @throws CannotHashEmptyPasswordException
     */
    public function register($username, $password, $about): User
    {
        $passwordHash = $this->passwordHasher->hashForPassword($password);
        return $this->repository->createUser($username, $passwordHash, $about);
    }
}
