<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Organization;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $incomeCategories = [
            'Salário',
            'Horas extras',
            'Investimentos',
            'Adiantamentos',
            'Outras receitas',
        ];

        $expenseCategories = [
            'Moradia',
            'Contas de Consumo',
            'Internet e Telecom',
            'Transporte',
            'Seguros',
            'Impostos',
            'Financiamentos',
            'Educação',
            'Reformas e Construção',
            'Contribuições Religiosas',
            'Associações',
            'Saúde',
            'Lazer',
            'Alimentação',
            'Outras despesas',
        ];

        foreach (Organization::all() as $org) {
            foreach ($incomeCategories as $name) {
                Category::firstOrCreate([
                    'organization_id' => $org->id,
                    'name' => $name,
                    'type' => 'recipe',
                ]);
            }

            foreach ($expenseCategories as $name) {
                Category::firstOrCreate([
                    'organization_id' => $org->id,
                    'name' => $name,
                    'type' => 'expense',
                ]);
            }
        }
    }
}
