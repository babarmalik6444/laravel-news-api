<?php

namespace App\Domains\DataSources\Contracts;
use Illuminate\Support\Collection;

interface NewsManagementInterface
{
    public function fetchData(): Collection;
    public function normaliseData(): Collection;
}
