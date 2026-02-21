<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class February2026Seeder extends Seeder
{
    public function run()
    {
        // use the first organization, or create one
        $orgId = DB::table('organizations')->value('id');
        if (!$orgId) {
            $orgId = DB::table('organizations')->insertGetId(['name' => 'Demo Org']);
        }

        $date = Carbon::create(2026, 2, 1);
        // ensure monthly control exists
        $mfcId = DB::table('monthly_financial_controls')
            ->where('organization_id', $orgId)
            ->where('month', $date->month)
            ->where('year', $date->year)
            ->value('id');
        if (!$mfcId) {
            $mfcId = DB::table('monthly_financial_controls')->insertGetId([
                'organization_id' => $orgId,
                'month' => $date->month,
                'year' => $date->year,
            ]);
        }

        // helper to ensure category exists
        $getCat = function (string $name, string $type) use ($orgId) {
            return DB::table('categories')
                ->where('name', $name)
                ->where('organization_id', $orgId)
                ->value('id')
                ?: DB::table('categories')->insertGetId([
                    'name' => $name,
                    'type' => $type,
                    'organization_id' => $orgId,
                ]);
        };

        // expenses
        $expenses = [
            ['Seguro Moto', 150.00],
            ['Dizimo IPB Leticia', 410.00],
            ['Dizimo IPB Ryan', 290.00],
            ['Apartamento', 911.00],
            ['Agua', 104.00],
            ['Luz', 111.38],
            ['Parcela Sitio', 140.00],
            ['IPVA', 196.60],
            ['Parcela Arquiteta', 481.00],
            ['Financ. Moto', 640.00],
            ['AAPI', 90.00],
            ['Curso de Inglês', 217.00],
            ['Internet Triade Fibra', 89.90],
        ];

        foreach ($expenses as [$name, $amt]) {
            $catId = $getCat($name, 'expense');
            DB::table('expenses')->insert([
                'organization_id' => $orgId,
                'category_id' => $catId,
                'name' => $name,
                'amount' => $amt,
                'transaction_date' => $date->format('Y-m-d'),
                'paid' => true,
                'paid_at' => $date->format('Y-m-d'),
                'monthly_financial_control_id' => $mfcId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // credit card statements
        $cards = [
            ['BANCO INTER', 1100.00],
            ['BANCO INTER LETICIA', 718.00],
            ['NUBANK', 482.00],
            ['CAIXA', 66.10],
        ];

        foreach ($cards as [$name, $amt]) {
            // ensure bank exists (use card name as bank name for simplicity)
            $bankId = DB::table('banks')->where('name', $name)->value('id')
                ?? DB::table('banks')->insertGetId(['name' => $name]);

            $exists = DB::table('credit_cards')
                ->where('name', $name)
                ->where('organization_id', $orgId)
                ->value('id');
            if (!$exists) {
                DB::table('credit_cards')->insert([
                    'organization_id' => $orgId,
                    'bank_id' => $bankId,
                    'name' => $name,
                    'bank' => $name,
                    'statement_amount' => $amt,
                    'paid' => true,
                    'paid_at' => $date->format('Y-m-d'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                // update amount in case changed
                DB::table('credit_cards')->where('id', $exists)->update([
                    'statement_amount' => $amt,
                    'paid' => true,
                    'paid_at' => $date->format('Y-m-d'),
                ]);
            }
        }

        // incomes / recipes
        $recipes = [
            ['Limpeza Prédio', 315.00],
            ['Horas Extras Leticia', 1061.00],
            ['Adiantamento', 1178.00],
            ['Salario Leticia', 3000.00],
            ['Salario Final Ryan', 1778.00],
        ];

        foreach ($recipes as [$name, $amt]) {
            $catId = $getCat($name, 'recipe');
            DB::table('recipes')->insert([
                'organization_id' => $orgId,
                'category_id' => $catId,
                'name' => $name,
                'amount' => $amt,
                'transaction_date' => $date->format('Y-m-d'),
                'received' => true,
                'received_at' => $date->format('Y-m-d'),
                'monthly_financial_control_id' => $mfcId,
                'fixed' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('February 2026 CSV data seeded.');
    }
}
