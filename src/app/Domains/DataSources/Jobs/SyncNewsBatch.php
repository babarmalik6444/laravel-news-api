<?php

namespace App\Domains\DataSources\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Domains\DataSources\Models\News;

class SyncNewsBatch implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private $data
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->data->each(function ($obj) {
            $news =  (new News)->fill($obj);
            $news->save();
            if ($obj['authors']) {
                $news->authors()->createMany($obj['authors']);
            }
        });
    }
}
