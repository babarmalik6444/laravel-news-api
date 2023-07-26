<?php

namespace App\Domains\Authors\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = [
        'name',
        'news_id'
    ];
}
