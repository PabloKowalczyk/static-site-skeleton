<?php

declare(strict_types=1);

namespace App\MenuBuilder;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

final class MainMenuItemFactory
{
    private FactoryInterface $factory;

    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function createItem(
        string $label,
        string $route = '',
        bool $subMenuRoot = false,
        array $childrenExtraClasses = [],
        array $itemExtraClasses = [],
        array $linkExtraClasses = []
    ): ItemInterface {
        $linkClasses = \array_merge(['nav-main__menu-link'], $linkExtraClasses);
        $itemClasses = \array_merge(['nav-main__menu-item'], $itemExtraClasses);
        $childrenClasses = \array_merge(
            ['nav-main__submenu', 'js-submenu'],
            $childrenExtraClasses,
        );
        if ($subMenuRoot) {
            $itemClasses[] = 'js-has-submenu';
            $linkClasses[] = 'nav-main__menu-link--has-submenu js-submenu-toggle';
        }

        if ('' === $route && false === $subMenuRoot) {
            throw new \RuntimeException('Unable to render item without route.');
        }

        $linkClassesString = \implode(' ', $linkClasses);
        $item = $this->factory
            ->createItem(
                $label,
                [
                    'route' => $route,
                    'translation_domain' => false,
                    'attributes' => [
                        'class' => \implode(' ', $itemClasses),
                    ],
                    'linkAttributes' => [
                        'class' => $linkClassesString,
                    ],
                    'labelAttributes' => [
                        'class' => $linkClassesString,
                    ],
                    'childrenAttributes' => [
                        'class' => \implode(' ', $childrenClasses),
                    ],
                ]
            )
        ;
        $item->setExtra('translation_domain', false);

        if (true === $subMenuRoot) {
            $item->setUri(null);
        }

        return $item;
    }
}
