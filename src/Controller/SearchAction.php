<?php

namespace App\Controller;

use App\Service\SearchHandlerFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: 'search/{search_string}', name:'search', methods: ['GET'])]
class SearchAction
{
    public function __construct(
        private SearchHandlerFactory $searchHandlerFactory,
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $searchHandler = $this->searchHandlerFactory->create($request->get('search_string'));

            return new JsonResponse([get_class($searchHandler)]);
        } catch (\Throwable $exception) {
            return new JsonResponse(['error' => 'Something went wrong.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}