<?php

namespace App\Controller;

use App\Service\EmailValidation\Exception\EmailValidationException;
use App\Service\SearchHandlerFactory;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: 'search/{search_string}', name:'search', methods: ['GET'])]
class SearchAction
{
    public function __construct(
        private SearchHandlerFactory $searchHandlerFactory,
        private LoggerInterface $logger,
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $this->logRequest($request);

            $searchString = $this->getSearchString($request);

            $handler = $this->searchHandlerFactory->create($searchString);

            return new JsonResponse(
                $handler->search($searchString),
                Response::HTTP_OK
            );
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

    private function getSearchString(Request $request): string
    {
        return trim($request->get('search_string'), " \n\r\t\v\0@");
    }

    private function logRequest(Request $request): void
    {
        $userAgent = $request->headers->get('User-Agent');
        $searchString = $this->getSearchString($request);

        $this->logger->info(sprintf('%s - %s', $userAgent, $searchString));
    }
}