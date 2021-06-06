<?php


namespace App\Services;


interface PasswordHasher
{
    public function hashForPassword(string $password): string;

    public function passwordMatchesHash(string $password, string $hash): bool;
}
