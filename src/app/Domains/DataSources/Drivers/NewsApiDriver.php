<?php

namespace App\Domains\DataSources\Drivers;

use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Collection;
use App\Domains\DataSources\Jobs\FetchApiDataJob;

class NewsApiDriver
{
    public function __construct(
        private array $apiServices
    ) {}

    public function fetchData()
    {
        foreach ($this->apiServices as $apiService) {
            Bus::dispatch(new FetchApiDataJob($apiService));
        }
    }
}
