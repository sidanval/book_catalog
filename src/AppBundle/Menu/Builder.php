<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root', [
            'childrenAttributes'    => array(
                'class'             => 'navbar-nav mr-auto',
            ),
        ]);

        $routes = [
            'Книги'      => 'app_book_index',
            'Жанры'     => 'genre_index',
            'Авторы'    => 'author_index',
        ];

        foreach ($routes as $label => $route) {
            $menu->addChild($label, [
                'route' => $route,
                'linkAttributes' => ['class' => 'nav-link'],
                'attributes' => ['class' => 'nav-item']
            ])->setExtra('translation_domain', false)
            ;
        }

        return $menu;
    }
}