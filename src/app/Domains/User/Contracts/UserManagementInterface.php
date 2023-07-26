<?php

namespace App\Domains\User\Contracts;

interface UserManagementInterface
{
    public function registerUser(string $name, string $email, string $password);
}
