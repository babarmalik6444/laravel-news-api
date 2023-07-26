<?php

namespace App\Domains\Authors\Services;

use App\Domains\Authors\Models\Author;

class AuthorsService
{
    public function getAuthors(): array
    {
        return Author::select('id', 'name')->get()->toArray();
    }
}
