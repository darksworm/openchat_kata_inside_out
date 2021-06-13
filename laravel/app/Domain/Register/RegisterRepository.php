<?php


namespace App\Domain\Register;


use App\Models\User;

class RegisterRepository
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
