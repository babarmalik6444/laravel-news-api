<?php

namespace App\Domains\Auth\Contracts;

use App\Domains\User\Models\User;

interface AuthManagementInterface
{
    public function login(string $email, string $password): User;

    public function logout(): void;
}
