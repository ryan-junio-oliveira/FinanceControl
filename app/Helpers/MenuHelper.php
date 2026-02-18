<?php

namespace App\Helpers;

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
                        'icon' => 'wallet',
                    ],
                    [
                        'name' => 'Despesas',
                        'path' => '/expenses',
                        'icon' => 'credit-card',
                    ],
                    [
                        'name' => 'Controles Mensais',
                        'path' => '/monthly-controls',
                        'icon' => 'calendar',
                    ],
                ],
            ],
            [
                'title' => 'Conta',
                'items' => [
                    [
                        'name' => 'Perfil',
                        'path' => '/dashboard',
                        'icon' => 'user',
                    ],
                ],
            ],
        ];
    }

    public static function getIconSvg(string $name): string
    {
        // Minimal set of inline SVG icons used by the sidebar.
        $icons = [
            'home' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 10.5L12 4L21 10.5V20a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1v-9.5z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
            'wallet' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21 12V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M16 8h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
            'credit-card' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="2" y="5" width="20" height="14" rx="2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M2 10h20" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
            'calendar' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="5" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M16 3v4M8 3v4M3 11h18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
            'user' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        ];

        return $icons[$name] ?? '';
    }
}
