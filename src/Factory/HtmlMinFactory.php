<?php

declare(strict_types=1);

namespace App\Factory;

use voku\helper\HtmlMin;
use voku\helper\HtmlMinInterface;

final class HtmlMinFactory
{
    public function create(): HtmlMinInterface
    {
        $htmlMin = new HtmlMin();
        $htmlMin
            ->doOptimizeAttributes()
            ->doSortCssClassNames()
            ->doSortHtmlAttributes()
        ;

        return $htmlMin;
    }
}
