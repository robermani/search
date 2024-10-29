<?php

// src/Service/SearchService.php
namespace App\Service;

class SearchService
{
    private $googleSearchEngine;
    private $bingSearchEngine;

    public function __construct(GoogleSearchEngine $googleSearchEngine, BingSearchEngine $bingSearchEngine)
    {
        $this->googleSearchEngine = $googleSearchEngine;
        $this->bingSearchEngine = $bingSearchEngine;
    }

    public function search(string $query): array
    {
        $googleResults = $this->googleSearchEngine->search($query);
        $bingResults = $this->bingSearchEngine->search($query);

        return [
            'google_results' => $googleResults,
            'bing_results' => $bingResults
        ];
    }
}
