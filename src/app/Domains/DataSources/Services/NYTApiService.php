<?php

namespace App\Domains\DataSources\Services;

use App\Domains\DataSources\Contracts\NewsManagementInterface;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Domains\DataSources\DTOs\NYTArticleDTO;

class NYTApiService implements NewsManagementInterface
{
    public function __construct(
        private $apiData = new Collection([])
    ) {}

    public function fetchData(): Collection
    {
        $url = env("NYTIMES_API_URL").'articlesearch.json';

        $queryString = http_build_query([
            'api-key' => env('NYTIME_API_KEY'),
            'begin_date' => Carbon::yesterday()->toDateString(),
            'end_date' => Carbon::today()->toDateString(),
        ]);

        $headers = [
            'Content-Type' => 'application/json',
        ];

        $totalHits = 0;

        try {
            $currentPage = 1;
            $pageSize = 100;

            do {
                $paginationParams = [
                    'page' => $currentPage,
                    'page-size' => $pageSize,
                ];

                $queryString .= '&' . http_build_query($paginationParams);

                $response = Http::withOptions([
                    'headers' => $headers,
                ])->get($url . '?' . $queryString);

                if ($response->successful()) {
                    $responseData = $response->json();
                    $docs = $response->collect('response.docs', []);
                    $this->apiData = $this->apiData->merge($docs);
                    $totalHits = data_get($responseData, 'response.meta.hits', 0);
                    $totalPages = ceil($totalHits / $pageSize);
                    $currentPage++;
                } else {
                    Log::error("API request failed with status code: " . $response->status());
                    break;
                }
            } while ($currentPage < $totalPages);
        } catch (\Exception $e) {
            Log::error("An error occurred: " . $e->getMessage());
        }

        return $this->apiData;
    }

    public function normaliseData(): Collection
    {
        $normalizedData = collect();
        if ($this->apiData) {
            foreach ($this->apiData as $data) {
                $normalizedData->push((new NYTArticleDTO($data))->toArray());
            }
        }

        return $normalizedData;
    }
}
