<?php

namespace App\Domains\DataSources\Models;

use App\Domains\Authors\Models\Author;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Laravel\Scout\Attributes\SearchUsingFullText;

class News extends Model
{
    use HasFactory, Searchable;

    protected $table = "news";

    protected $fillable = [
        'title',
        'abstract',
        'details',
        'source',
        'web_url',
        'published_at',
        'img',
        'api_source',
        'type'
    ];

    /**
     * Get the index able data array for the model.
     *
     * @return array<string, mixed>
     */
    #[SearchUsingFullText(['title', 'abstract', 'details'])]
    public function toSearchableArray(): array
    {
        return [
            'title' => $this->title,
            'abstract' => $this->abstract,
            'details' => $this->details,
        ];
    }

    public function authors() {
        return $this->hasMany(Author::class, 'news_id', 'id');
    }
}
