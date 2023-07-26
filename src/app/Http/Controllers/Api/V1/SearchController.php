<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Domains\Search\Libraries\SearchLibrary;
use App\Domains\Search\Requests\SearchRequest;

class SearchController extends Controller
{
    public function __construct(
        private  SearchLibrary $searchLibrary
    ) {}

    public function index(SearchRequest $request) {
        $searchParams = $request->validated();
        $this->searchLibrary->setKeywords(($searchParams['keywords'] ?? ''));
        $this->searchLibrary->setAuthors(($searchParams['authors'] ?? []));
        $this->searchLibrary->setSources(($searchParams['sources'] ?? []));
        $this->searchLibrary->setTypes(($searchParams['types'] ?? []));
        $data = $this->searchLibrary->getNews();
        return response()->json(['message' => 'News feed', 'data' => $data]);
    }
}
