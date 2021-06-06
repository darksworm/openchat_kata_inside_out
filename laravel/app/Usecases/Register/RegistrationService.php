<?php


namespace App\Usecases\Register;


use App\Usecases\HashPassword\CannotHashEmptyPasswordException;
use App\Usecases\HashPassword\PasswordHasher;

class RegistrationService
{
    private UserRegistrationRepository $repository;
    private PasswordHasher $passwordHasher;

    public function __construct(UserRegistrationRepository $repository, PasswordHasher $passwordHasher)
    {
        $this->repository = $repository;
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @throws DuplicateUsernameException
     * @throws CannotHashEmptyPasswordException
     */
    public function register($username, $password, $about)
    {
        $passwordHash = $this->passwordHasher->hashForPassword($password);
        $this->repository->createUser($username, $passwordHash, $about);
    }
}
