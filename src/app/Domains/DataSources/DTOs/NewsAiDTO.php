<?php

namespace App\Domains\DataSources\DTOs;

use App\Domains\DataSources\Enums\ApiSourcesEnum;
use Spatie\DataTransferObject\DataTransferObject;
use Carbon\Carbon;

class NewsAiDTO extends DataTransferObject
{
    public mixed $title;
    public mixed $abstract;
    public mixed $details;
    public mixed $source;
    public string $type;
    public mixed $web_url;
    public ?string $published_at;
    public mixed $img;
    public string $api_source;
    public ?array $authors;

    public function __construct(array $data)
    {
        $this->title = $data['title'] ?? '';
        $this->abstract = '';
        $this->details = $data['body'] ?? '';
        $this->source = $data['source']['title'] ?? '';
        $this->type = $data['dataType'] ?? '';
        $this->web_url = $data['url'] ?? '';
        $this->published_at = isset($data['dateTimePub']) ? Carbon::parse($data['dateTimePub'])->toDateTimeString() : null;
        $this->img = $data['image'] ?? null;
        $this->api_source = ApiSourcesEnum::NewsAiApi;
        //get authors names
        $this->authors = [];
        $authorsData = data_get($data, 'authors', []);
        foreach ($authorsData as $authorData) {
            $this->authors[]['name'] = $authorData['name'];
        }
    }
}
