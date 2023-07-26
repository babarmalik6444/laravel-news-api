<?php

namespace App\Domains\DataSources\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Domains\DataSources\Contracts\NewsManagementInterface;

class FetchApiDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private NewsManagementInterface $apiService
    ) {}

    public function handle()
    {
        $this->apiService->fetchData();
        $normalisedData = collect($this->apiService->normaliseData());
        dispatch(New SyncNewsBatch($normalisedData));
    }
}
