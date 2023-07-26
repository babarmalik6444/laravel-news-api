<?php
namespace App\Domains\Search\Services;

use App\Domains\DataSources\Models\News;

class FiltersService
{
    function getSources(): array
    {
        return News::select('source')->distinct()->get()->toArray();
    }

    function getTypes(): array
    {
        return News::select('type')->distinct()->get()->toArray();
    }
}
