<?php

declare(strict_types=1);

namespace App\Controller;

use App\Response\ResponseRenderer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class TemplateAction
{
    private ResponseRenderer $responseRenderer;

    public function __construct(ResponseRenderer $responseRenderer)
    {
        $this->responseRenderer = $responseRenderer;
    }

    public function __invoke(string $template, Request $request): Response
    {
        return $this->responseRenderer
            ->renderResponse($template)
        ;
    }
}
