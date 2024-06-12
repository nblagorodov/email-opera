<?php

namespace App\Controller;

use App\Service\EmailValidation\Exception\EmailValidationException;
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
            $searchString = $request->get('search_string');

            $searchHandler = $this->searchHandlerFactory->create($request->get('search_string'));
            $searchHandler->search($searchString);

            return new JsonResponse(['success' => true]);
        } catch (EmailValidationException $exception) {
            return new JsonResponse([
                'success' => false,
                'error' => sprintf('email is invalid: %s.', $exception->getMessage()),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Throwable) {
            return new JsonResponse([
                'success' => false,
                'error' => 'something went wrong.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}