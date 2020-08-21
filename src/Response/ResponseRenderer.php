<?php

declare(strict_types=1);

namespace App\Response;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use voku\helper\HtmlMinInterface;

final class ResponseRenderer
{
    private Environment $twig;
    private HtmlMinInterface $htmlMin;
    private bool $isDebug;

    public function __construct(
        Environment $twig,
        HtmlMinInterface $htmlMin,
        bool $isDebug
    ) {
        $this->twig = $twig;
        $this->htmlMin = $htmlMin;
        $this->isDebug = $isDebug;
    }

    public function renderResponse(
        string $template,
        array $params = [],
        bool $public = true
    ): Response {
        $content = $this->twig
            ->render($template, $params)
        ;
        $response = new Response();

        if ($public) {
            $response
                ->setPublic()
                ->setSharedMaxAge(7200)
            ;
            $content = $this->isDebug
                ? $content
                : $this->htmlMin
                    ->minify($content)
            ;
        }

        $response->setContent($content);

        return $response;
    }
}
