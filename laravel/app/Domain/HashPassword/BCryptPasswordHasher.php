<?php


namespace App\Domain\HashPassword;


class BCryptPasswordHasher implements PasswordHasher
{
    public function hashForPassword(string $password): string
    {
        if (!$password) {
            throw new CannotHashEmptyPasswordException();
        }

        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function passwordMatchesHash(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}
