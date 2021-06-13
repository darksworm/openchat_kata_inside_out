<?php


namespace App\Domain\HashPassword;


use Illuminate\Support\ServiceProvider;

class PasswordHasherProvider extends ServiceProvider
{
    public array $singletons = [
        PasswordHasher::class => BCryptPasswordHasher::class
    ];
}
