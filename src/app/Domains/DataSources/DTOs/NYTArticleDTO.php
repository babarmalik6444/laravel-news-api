<?php
namespace App\Domains\DataSources\DTOs;

use App\Domains\DataSources\Enums\ApiSourcesEnum;
use Spatie\DataTransferObject\DataTransferObject;
use Carbon\Carbon;

class NYTArticleDTO extends DataTransferObject
{
    public string $title;
    public string $abstract;
    public string $details;
    public string $source;
    public string $type;
    public mixed $web_url;
    public ?string $published_at;
    public mixed $img;
    public string $api_source;
    public ?array $authors;

    public function __construct(array $data)
    {
        $this->title = $data['headline']['main'] ?? '';
        $this->abstract = $data['abstract'] ?? '';
        $this->details = $data['lead_paragraph'] ?? '';
        $this->source = $data['source'] ?? '';
        $this->type = $data['type_of_material'] ?? '';
        $this->web_url = $data['web_url'] ?? '';
        $this->published_at = isset($data['pub_date']) ? Carbon::parse($data['pub_date'])->toDateTimeString() : null;
        $this->img = data_get($data, 'multimedia.0.url', null);
        if ($this->img) {
            $this->img = 'https://www.nytimes.com/'.$this->img;
        }
        $this->api_source = ApiSourcesEnum::NYTimesApi;
        //get authors names
        $this->authors = [];
        $authorsData = data_get($data, 'byline.person', []);
        foreach ($authorsData as $authorData) {
            $fullname = $authorData['firstname'];
            if ($authorData['lastname'] !== null) {
                $fullname .= ' ' . $authorData['lastname'];
            }
            $this->authors[]['name'] = $fullname;
        }
    }
}
