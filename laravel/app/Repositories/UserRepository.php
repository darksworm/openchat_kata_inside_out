<?php


namespace App\Repositories;


use App\Exceptions\DuplicateUsernameException;
use App\Models\User;

class UserRepository
{
    public function getUserCount(): int
    {
        return User::count();
    }

    public function createUser(string $username, string $password, string $about): User
    {
        if ($this->userWithUsernameExists($username)) {
            throw new DuplicateUsernameException();
        }

        $user = new User([
            'username' => $username,
            'password' => $password,
            'about' => $about
        ]);
        $user->save();

        return $user;
    }

    private function userWithUsernameExists(string $username): bool
    {
        return User::where('username', $username)->exists();
    }
}
