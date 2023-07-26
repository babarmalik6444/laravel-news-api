<?php

namespace App\Domains\DataSources\Services;

use App\Domains\DataSources\Contracts\NewsManagementInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Domains\DataSources\DTOs\NewsAiDTO;

class NewsAiApiService implements NewsManagementInterface
{
    public function __construct(
        private $apiData = new Collection([])
    ) {}
    public function fetchData(): Collection
    {
        $url = env("NEWSAI_API_URL").'article/getArticles';
        $apiKey = env("NEWSAI_API_KEY");
        $resultType = 'articles';
        $articleBodyLen = -1;
        $dataType = 'news';
        $query = [
            '$query' => [
                '$and' => [
                    [
                        'lang' => 'eng',
                        'dateStart' => Carbon::yesterday()->toDateString(),
                        'dateEnd' => Carbon::today()->toDateString(),
                    ],
                ],
            ],
        ];

        $queryString = http_build_query([
            'apiKey' => $apiKey,
            'resultType' => $resultType,
            'articleBodyLen' => $articleBodyLen,
            'dataType' => $dataType,
            'query' => json_encode($query),
        ]);

        $headers = [
            'Content-Type' => 'application/json',
        ];

        try {
            $currentPage = 1;
            $totalPages = 1;

            do {
                $fullUrl = $url . '?' . $queryString . '&page=' . $currentPage;
                $response = Http::withOptions([
                    'headers' => $headers,
                ])->get($fullUrl);

                if ($response->successful()) {
                    $responseData = $response->collect($resultType);
                    $this->apiData = $this->apiData->merge($responseData['results']);
                    $totalPages = $responseData['pages'];
                    $currentPage++;
                } else {
                    Log::error("API request failed with status code: " . $response->status());
                    break;
                }
            } while ($currentPage <= $totalPages);
        } Catch (\Exception $e) {
            Log::error("An error occurred: " . $e->getMessage());
        }
        return $this->apiData;
    }

    public function normaliseData(): Collection
    {
        $normalizedData = collect();

        if ($this->apiData) {
            foreach ($this->apiData as $data) {
                $normalizedData->push((new NewsAiDTO($data))->toArray());
            }
        }

        return $normalizedData;
    }
}
