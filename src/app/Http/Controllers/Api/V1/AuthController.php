<?php

namespace App\Http\Controllers\Api\V1;

use App\Domains\Auth\Requests\LoginRequest;
use App\Domains\Auth\Contracts\AuthManagementInterface;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function __construct(
        private AuthManagementInterface $authManagement
    ) {}

    final public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        $authenticated = $this->authManagement->login($credentials['email'], $credentials['password']);
        if ($authenticated) {
            return response()->json(['message' => 'Login successful', 'user' => $authenticated]);
        }

        return response()->json(['message' => 'Invalid Credentials'], 401);
    }

    final public function logout()
    {
        $this->authManagement->logout();
        return response()->json(['message' => 'Logout successful']);
    }
}
