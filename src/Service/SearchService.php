<?php

// src/Service/SearchService.php
namespace App\Service;

use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class SearchService
{
    private $googleSearchEngine;
    private $bingSearchEngine;
    private $cache;

    public function __construct(GoogleSearchEngine $googleSearchEngine, BingSearchEngine $bingSearchEngine, CacheInterface $cache)
    {
        $this->googleSearchEngine = $googleSearchEngine;
        $this->bingSearchEngine = $bingSearchEngine;
        $this->cache = $cache;
    }

    public function search(string $query): array
    {

        return $this->cache->get('search_results_' . md5($query), function (ItemInterface $item) use ($query) {
            $item->expiresAfter($_ENV['CACHE_EXPIRATION_TIME'] ?? 3600);

            $googleResults = $this->googleSearchEngine->search($query);
            $bingResults = $this->bingSearchEngine->search($query);

            return [
                'google_results' => $googleResults,
                'bing_results' => $bingResults
            ];
        });
    }
}

