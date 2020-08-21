<?php

declare(strict_types=1);

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class FileSourceExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [new TwigFunction('file_source', [$this, 'fileSource'])];
    }

    public function fileSource(string $filePath): string
    {
        if (!\file_exists($filePath)) {
            throw new \RuntimeException("File '{$filePath}' doesn't exists.");
        }

        $content = \file_get_contents($filePath);
        if (false === $content) {
            throw new \RuntimeException("Unable to load content of file '{$filePath}'.");
        }

        return $content;
    }
}
