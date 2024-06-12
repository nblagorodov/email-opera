<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;

#[Route(path: ['/', '/index'], name: 'index', methods: ['GET'])]
final readonly class IndexAction
{
    public function __construct(
        private Environment $twigEnvironment,
    ) {
    }

    public function __invoke(): Response
    {
        return new Response(
            $this->twigEnvironment->render('base.html.twig'),
            Response::HTTP_OK,
        );
    }
}