<?php

// src/Service/BingSearchEngine.php
namespace App\Service;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class BingSearchEngine
{
    public function search(string $query, int $resultsAmount = 1, int $chunk = 1): array
    {
        $url = 'https://www.bing.com/search?q=' . urlencode($query);
        $client = new Client();
        $response = $client->request('GET', $url, [
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.4951.54 Safari/537.36'
            ]
        ]);

        $html = $response->getBody()->getContents();
        $crawler = new Crawler($html);
        $results = [];
        $crawler->filter('li.b_algo')->each(function (Crawler $node, $i) use (&$results, $resultsAmount, $chunk) {
            $start = ($chunk - 1) * $resultsAmount;
            $end = $chunk * $resultsAmount;
            if ($i >= $start && $i < $end) {
                $title = $node->filter('h2')->text('');
                $link = $node->filter('a')->attr('href');

                if ($title && $link) {
                    $results[] = [
                        'title' => $title,
                        'link' => $link,
                    ];
                }
            }
        });

        return $results;
    }
}

