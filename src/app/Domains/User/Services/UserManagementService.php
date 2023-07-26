<?php

namespace App\Domains\User\Services;

use App\Domains\User\Contracts\UserManagementInterface;
use App\Domains\User\Models\User;

class UserManagementService implements UserManagementInterface
{
    public function registerUser(string $name, string $email, string $password): User
    {
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
        ]);

        return $user;
    }
}
