<?php

namespace App\Domains\Search\Libraries;
use App\Domains\DataSources\Models\News;

class SearchLibrary
{
    private $keywords = '';
    private $types = [];
    private $sources = [];
    private $authors = [];

    public function setKeywords(string $keywords)
    {
        $this->keywords = $keywords;
    }

    public function getKeywords()
    {
        return $this->keywords;
    }

    public function setTypes(array $types)
    {
        $this->types = $types;
    }

    public function getTypes()
    {
        return $this->types;
    }

    public function setSources(array $sources)
    {
        $this->sources = $sources;
    }

    public function getSources()
    {
        return $this->sources;
    }

    public function setAuthors(array $authors)
    {
        $this->authors = $authors;
    }

    public function getAuthors()
    {
        return $this->authors;
    }

    public function getNews(array $data = [])
    {
        $query = News::with('authors');
        if (!empty($this->getKeywords())) {
            $query = News::search($this->getKeywords())->query(function ($query) {
                $query->with('authors')
                ->when($this->getAuthors(), function ($query) {
                    $query->whereHas('authors', function ($q) {
                        $q->whereIn('id', $this->getAuthors());
                    });
                });
            });
        } else {
            $query->when($this->getAuthors(), function ($query) {
                    $query->whereHas('authors', function ($q) {
                        $q->whereIn('id', $this->getAuthors());
                    });
                });
        }
        if ($this->getTypes()) {
            $query = $query->whereIn('type', $this->getTypes());
        }

        if ($this->getSources()) {
            $query = $query->whereIn('source', $this->getSources());
        }

        return $query->paginate(50);
    }
}

