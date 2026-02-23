<?php

namespace App\Modules\Shared\Presentation\Helpers;

use Illuminate\Support\Facades\Auth;

class MenuHelper
{
    public static function getMenuGroups(): array
    {
        $principalItems = [[
            'name' => 'Dashboard',
            'path' => '/dashboard',
            'route' => 'dashboard',
            'icon' => 'home',
        ]];

        // root user sees configuration link + admin modules
        if (Auth::check() && Auth::user()->hasRole('root')) {
            $principalItems[] = [
                'name' => 'Configurações',
                'path' => '/admin/settings',
                'route' => 'admin.settings',
                'icon' => 'cog',
            ];
            $principalItems[] = [
                'name' => 'Bancos',
                'path' => '/admin/banks',
                'route' => 'admin.banks.*',
                'icon' => 'bank',
            ];
            $principalItems[] = [
                'name' => 'Categorias',
                'path' => '/admin/categories',
                'route' => 'admin.categories.*',
                'icon' => 'tags',
            ];
        }

        return [
            [
                'title' => 'Principal',
                'items' => $principalItems,
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
                        'name' => 'Cartões',
                        'path' => '/credit-cards',
                        'route' => 'credit-cards.*',
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
            'cog' => '<i class="fa-solid fa-cog fa-fw"></i>',
        ];

        return $icons[$name] ?? '';
    }
}
