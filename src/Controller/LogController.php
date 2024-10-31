<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LogController
{
    /**
     * @Route("/log", name="log", methods={"POST"})
     */
    public function log(Request $request, LoggerInterface $logger): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $logger->error($data['error']);

        return new JsonResponse(['status' => 'ok']);
    }
}
