<?php

namespace App\Http\Controllers\Api\V1;

use App\Domains\Authors\Services\AuthorsService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Domains\Search\Services\FiltersService;

class FiltersController extends Controller
{
    public function __construct(
        private FiltersService $filtersService,
        private AuthorsService $authorsService
    )
    {}

    public function getFilters()
   {
       $data['authors'] = $this->authorsService->getAuthors();
       $data['types'] =  $this->filtersService->getTypes();
       $data['sources'] =  $this->filtersService->getSources();
       return response()->json(['message' => 'Filters list', 'data' => $data]);
   }
}
