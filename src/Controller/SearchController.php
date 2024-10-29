<?php

// src/Controller/SearchController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Service\SearchService;

class SearchController extends AbstractController
{
    private $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    public function search(Request $request): JsonResponse
    {
        $query = $request->query->get('q');

        // Validate the query parameter
        if (empty($query) || !is_string($query)) {
            return new JsonResponse(['error' => 'Invalid query parameter.'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $results = $this->searchService->search($query);

        return new JsonResponse([
            'query' => $query,
            'google_results' => $results['google_results'],
            'bing_results' => $results['bing_results']
        ]);
    }
}
