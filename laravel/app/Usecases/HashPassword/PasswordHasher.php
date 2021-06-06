<?php


namespace App\Usecases\HashPassword;


interface PasswordHasher
{
    public function hashForPassword(string $password): string;

    public function passwordMatchesHash(string $password, string $hash): bool;
}
