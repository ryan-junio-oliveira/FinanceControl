<?php

namespace App\Modules\Shared\Presentation\Helpers;

class MenuHelper
{
    public static function getMenuGroups(): array
    {
        return [
            [
                'title' => 'Principal',
                'items' => [
                    [
                        'name' => 'Dashboard',
                        'path' => '/dashboard',
                        'route' => 'dashboard',
                        'icon' => 'home',
                    ],
                ],
            ],
            [
                'title' => 'Financeiro',
                'items' => [
                    [
                        'name' => 'Receitas',
                        'path' => '/recipes',
                        'route' => 'recipes.*',
                        'icon' => 'wallet',
                    ],
                    [
                        'name' => 'Despesas',
                        'path' => '/expenses',
                        'route' => 'expenses.*',
                        'icon' => 'credit-card',
                    ],
                    [
                        'name' => 'Investimentos',
                        'path' => '/investments',
                        'route' => 'investments.*',
                        'icon' => 'chart-line',
                    ],
                    [
                        'name' => 'Orçamentos',
                        'path' => '/budgets',
                        'route' => 'budgets.*',
                        'icon' => 'tags',
                    ],
                    // [
                    //     'name' => 'Categorias',
                    //     'path' => '/categories',
                    //     'route' => 'categories.*',
                    //     'icon' => 'tags',
                    // ],
                    // [
                    //     'name' => 'Controles Mensais',
                    //     'path' => '/monthly-controls',
                    //     'route' => 'monthly-controls.*',
                    //     'icon' => 'calendar',
                    // ],
                    // [
                    //     'name' => 'Bancos',
                    //     'path' => '/banks',
                    //     'route' => 'banks.*',
                    //     'icon' => 'bank',
                    // ],
                    [
                        'name' => 'Cartões',
                        'path' => '/credit-cards',
                        'route' => 'credit-cards.*',
                        'icon' => 'credit-card',
                    ],
                ],
            ],
            [
                'title' => 'Conta',
                'items' => [
                    [
                        'name' => 'Perfil',
                        'path' => '/dashboard',
                        'route' => 'dashboard',
                        'icon' => 'user',
                    ],
                ],
            ],
        ];
    }

    public static function getIconSvg(string $name): string
    {
        // Return Font Awesome HTML for menu icons (keeps legacy method name for compatibility).
        $icons = [
            'home' => '<i class="fa-solid fa-house fa-fw"></i>',
            'wallet' => '<i class="fa-solid fa-wallet fa-fw"></i>',
            'credit-card' => '<i class="fa-solid fa-credit-card fa-fw"></i>',
            'calendar' => '<i class="fa-solid fa-calendar-days fa-fw"></i>',
            'bank' => '<i class="fa-solid fa-building-columns fa-fw"></i>',
            'user' => '<i class="fa-solid fa-user fa-fw"></i>',
            'tags' => '<i class="fa-solid fa-tags fa-fw"></i>',
            'chart-line' => '<i class="fa-solid fa-chart-line fa-fw"></i>',
        ];

        return $icons[$name] ?? '';
    }
}
