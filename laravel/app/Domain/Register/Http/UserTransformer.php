<?php


namespace App\Domain\Register\Http;


use App\Models\User;

class UserTransformer
{

    public static function transform(User $user)
    {
        return [
            'id' => $user->user_id,
            'username' => $user->username,
            'about' => $user->about
        ];
    }
}
