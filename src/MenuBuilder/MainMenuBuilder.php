<?php

declare(strict_types=1);

namespace App\MenuBuilder;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

final class MainMenuBuilder
{
    private FactoryInterface $factory;
    private FoodSubMenuBuilder $foodSubMenuBuilder;
    private MainMenuItemFactory $menuItemFactory;
    private DocumentationSubMenuBuilder $documentationSubMenuBuilder;
    private BioFuelsSubMenuBuilder $bioFuelsSubMenuBuilder;
    private TransportSubMenuBuilder $transportSubMenuBuilder;
    private ServicesSubMenuBuilder $servicesSubMenuBuilder;
    private AuditsSubMenuBuilder $auditsSubMenuBuilder;
    private ImplementationsSubMenuBuilder $implementationsSubMenuBuilder;
    private PricingSubMenuBuilder $pricingSubMenuBuilder;

    public function __construct(
        FactoryInterface $factory,
        MainMenuItemFactory $menuItemFactory
    ) {
        $this->factory = $factory;
        $this->menuItemFactory = $menuItemFactory;
    }

    public function create(array $options): ItemInterface
    {
        $menu = $this->factory
            ->createItem(
                'root',
                [
                    'childrenAttributes' => [
                        'class' => 'nav-main__menu-list js-nav-main-list',
                    ],
                ]
            )
        ;

        $menu->addChild(
            $this->menuItemFactory
                ->createItem(
                    'Homepage',
                    'index',
                )
        );

        return $menu;
    }
}
