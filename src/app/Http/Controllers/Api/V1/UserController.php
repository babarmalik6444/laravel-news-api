<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Domains\User\Contracts\UserManagementInterface;
use App\Domains\User\Requests\CreateUserRequest;

class UserController extends Controller
{
    public function __construct(
        private UserManagementInterface $userManagement
    ) {}

    public function store(CreateUserRequest $request)
    {
        $data = $request->validated();
        $user = $this->userManagement->registerUser($data['name'], $data['email'], $data['password']);
        return response()->json(['message' => 'Account created successfully', 'data' => $user]);
    }
}
