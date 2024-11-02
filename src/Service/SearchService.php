<?php

namespace App\Service;

use App\Entity\SearchResult;
use App\Repository\SearchResultRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class SearchService
{
    private GoogleSearchEngine $googleSearchEngine;
    private BingSearchEngine $bingSearchEngine;
    private ?CacheInterface $cache;
    private EntityManagerInterface $entityManager;

    public function __construct(
        GoogleSearchEngine $googleSearchEngine,
        BingSearchEngine $bingSearchEngine,
        EntityManagerInterface $entityManager,
        CacheInterface $cache = null
    ) {
        $this->googleSearchEngine = $googleSearchEngine;
        $this->bingSearchEngine = $bingSearchEngine;
        $this->entityManager = $entityManager;
        $this->cache = $cache;
    }

    public function search(string $query, int $resultsAmount, int $chunk): array
    {
        $results = $this->cache && $chunk == 1
            ? $this->cache->get('search_results_' . md5($query), function (ItemInterface $item) use ($query, $resultsAmount, $chunk) {
                $item->expiresAfter($_ENV['CACHE_EXPIRATION_TIME'] ?? 3600);
                return $this->fetchAndSaveResults($query, $resultsAmount, $chunk);
            })
            : $this->fetchAndSaveResults($query, $resultsAmount, $chunk);

        return $results;
    }

    private function fetchAndSaveResults(string $query, int $resultsAmount, int $chunk): array
    {
        $googleResults = $this->googleSearchEngine->search($query, $resultsAmount, $chunk);
        $bingResults = $this->bingSearchEngine->search($query, $resultsAmount, $chunk);

        // Save each result to the database
        $this->saveResults($googleResults, 'Google');
        $this->saveResults($bingResults, 'Bing');

        return [
            'google_results' => $googleResults,
            'bing_results' => $bingResults,
        ];
    }

    private function saveResults(array $results, string $searchEngine): void
    {
        foreach ($results as $result) {
            $searchResult = new SearchResult();
            $searchResult->setSearchEngine($searchEngine);
            $searchResult->setTitle($result['title']); // assuming the result has a 'title' field
            $searchResult->setEnteredDate(new \DateTimeImmutable());

            $this->entityManager->persist($searchResult);
        }

        $this->entityManager->flush();
    }
}
