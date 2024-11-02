<?php

namespace App\Tests\Service;

use App\Service\BingSearchEngine;
use App\Service\GoogleSearchEngine;
use App\Service\MyService;
use App\Service\SearchService;
use PHPUnit\Framework\TestCase;

class SearchServiceTest extends TestCase
{
    public function testSomething()
    {
        $actual_result = [
            'google_results_amount' => 0,
            'bing_results_amount' => 0,
        ];
        $expectedResult = [
            'google_results_amount' => 5,
            'bing_results_amount' => 5,
        ];
        $googleSearchEngine = new GoogleSearchEngine();
        $bingSearchEngine = new BingSearchEngine();
        $service = new SearchService($googleSearchEngine, $bingSearchEngine);
        $query = 'ewave';
        $results = $service->search($query);
        if (!empty($results['google_results']) && is_array($results['google_results'])) {
            $actual_result['google_results_amount'] = count($results['google_results']);
        }
        if (!empty($results['bing_results']) && is_array($results['bing_results'])) {
            $actual_result['bing_results_amount'] = count($results['bing_results']);
        }

        $this->assertEquals($expectedResult, $actual_result);
    }
}
