<?php

namespace App\Domains\Auth\Services;

use App\Domains\Auth\Contracts\AuthManagementInterface;
use App\Domains\User\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

class AuthService implements AuthManagementInterface
{
    public function login(string $email, string $password): User
    {
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $user = Auth::user();
            $token = $user->createToken('AuthToken')->plainTextToken;
            $user->token = $token;
            return $user;
        }

        throw new AuthenticationException();
    }

    public function logout(): void
    {
        Auth::user()->currentAccessToken()->delete();
    }
}
