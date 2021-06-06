<?php


namespace App\Services;


use App\Exceptions\CannotHashEmptyPasswordException;
use App\Exceptions\DuplicateUsernameException;
use App\Repositories\UserRepository;

class UserService
{
    private UserRepository $repository;
    private PasswordHasher $passwordHasher;

    public function __construct(UserRepository $repository, PasswordHasher $passwordHasher)
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
