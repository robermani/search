<?php

// src/Service/SearchService.php
namespace App\Service;

use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class SearchService
{
    private BingSearchEngine $bingSearchEngine;
    private GoogleSearchEngine $googleSearchEngine;
    private ?CacheInterface $cache;

    public function __construct(GoogleSearchEngine $googleSearchEngine, BingSearchEngine $bingSearchEngine, CacheInterface $cache = null)
    {
        $this->googleSearchEngine = $googleSearchEngine;
        $this->bingSearchEngine = $bingSearchEngine;
        $this->cache = $cache;
    }

    public function search(string $query, int $resultsAmount, int $chunk): array
    {
        if ($this->cache && $chunk == 1) {
            return $this->cache->get('search_results_' . md5($query), function (ItemInterface $item) use ($query, $resultsAmount, $chunk) {
                $item->expiresAfter($_ENV['CACHE_EXPIRATION_TIME'] ?? 3600);
                $googleResults = $this->googleSearchEngine->search($query, $resultsAmount, $chunk);
                $bingResults = $this->bingSearchEngine->search($query, $resultsAmount, $chunk);

                return [
                    'google_results' => $googleResults,
                    'bing_results' => $bingResults
                ];
            });
        } else {
            $googleResults = $this->googleSearchEngine->search($query, $resultsAmount, $chunk);
            $bingResults = $this->bingSearchEngine->search($query, $resultsAmount, $chunk);

            return [
                'google_results' => $googleResults,
                'bing_results' => $bingResults
            ];
        }
    }
}
