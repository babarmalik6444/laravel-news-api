<?php

namespace App\Domains\DataSources\Managers;

use Illuminate\Support\Collection;
use App\Domains\DataSources\Drivers\NewsApiDriver;

class NewsApiManager
{
    public function __construct(
        private NewsApiDriver $apiDriver
    ) {}

    public function fetchAndNormalizeData()
    {
        $this->apiDriver->fetchData();
    }
}
