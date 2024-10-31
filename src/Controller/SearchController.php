<?php

// src/Controller/SearchController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Psr\Log\LoggerInterface;
use App\Service\SearchService;

class SearchController extends AbstractController
{
    private $searchService;
    private $logger;

    public function __construct(SearchService $searchService, LoggerInterface $logger)
    {
        $this->searchService = $searchService;
        $this->logger = $logger;
    }

    public function search(Request $request): JsonResponse
    {
        $query = $request->query->get('q');

        // Validate the query parameter
        if (empty($query) || !is_string($query)) {
            return new JsonResponse(['error' => 'Invalid query parameter.'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $results = $this->searchService->search($query);

        if (empty($results)) {
            $this->logger->error('No results.', ['query' => $query]);
        }
        if (empty($results['google_results'])) {
            $this->logger->error('No results from Google search engine.', ['query' => $query]);
        }
        if (empty($results['bing_results'])) {
            $this->logger->error('No results from Bing search engine.', ['query' => $query]);
        }

        return new JsonResponse([
            'query' => $query,
            'results' => [
                'google' => $results['google_results'],
                'bing' => $results['bing_results']
            ]
        ]);
    }
}
