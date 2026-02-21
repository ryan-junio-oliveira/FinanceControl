<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FinancialDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * This seeder will populate one organization (if none exists) and then
     * create three months' worth of financial controls with a fixed salary
     * income of 3000, expenses totalling 1500, and investments of 1500.
     */
    public function run()
    {
        // ensure there is at least one organization and user
        $orgId = DB::table('organizations')->value('id');
        if (!$orgId) {
            $orgId = DB::table('organizations')->insertGetId(['name' => 'Demo Org']);
            // ensure at least one user exists for the organization
            DB::table('users')->insert([
                'name' => 'Demo User',
                'email' => 'demo@example.com',
                'password' => bcrypt('password'),
                'organization_id' => $orgId,
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ensure categories exist – a few income and expense categories
        $incomeCats = ['Salário', 'Freelance', 'Outras receitas'];
        $expenseCats = ['Despesas', 'Investimentos', 'Alimentação', 'Transporte'];

        $catIds = [];
        foreach ($incomeCats as $name) {
            $catIds[$name] = DB::table('categories')
                ->where('name', $name)
                ->where('organization_id', $orgId)
                ->value('id')
                ?? DB::table('categories')->insertGetId([
                    'name' => $name,
                    'type' => 'recipe', // enum defined as recipe for incomes
                    'organization_id' => $orgId,
                ]);
        }
        foreach ($expenseCats as $name) {
            $catIds[$name] = DB::table('categories')
                ->where('name', $name)
                ->where('organization_id', $orgId)
                ->value('id')
                ?? DB::table('categories')->insertGetId([
                    'name' => $name,
                    'type' => 'expense',
                    'organization_id' => $orgId,
                ]);
        }

        // create some credit card banks and cards if they don't already exist
        $banks = ['SICOOB','INTER','SANTANDER'];
        foreach ($banks as $bn) {
            $existing = DB::table('banks')->where('name', $bn)->value('id');
            if (!$existing) {
                DB::table('banks')->insertGetId(['name' => $bn]);
            }
        }
        $cards = ['Visa','Mastercard','Elo'];
        foreach ($cards as $idx => $cn) {
            $exists = DB::table('credit_cards')
                ->where('name', $cn)
                ->where('organization_id', $orgId)
                ->value('id');
            if (!$exists) {
                DB::table('credit_cards')->insert([
                    'name' => $cn,
                    'bank_id' => $idx + 1,
                    'bank' => $banks[$idx],
                    'statement_amount' => 500.00 + 100 * $idx,
                    'organization_id' => $orgId,
                ]);
            }
        }

        // generate three months starting with current, distribute amounts among categories
        for ($i = 0; $i < 3; $i++) {
            $date = Carbon::now()->startOfMonth()->subMonths($i);
            // do not duplicate existing monthly control
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

            // incomes (recipes): split 3000 across all income cats
            $amt = 3000.00 / count($incomeCats);
            foreach ($incomeCats as $name) {
                $dt = $date->copy()->addDays(1)->format('Y-m-d');
                DB::table('recipes')->insert([
                    'name' => $name,
                    'amount' => round($amt,2),
                    'transaction_date' => $dt,
                    'received' => true,
                    'received_at' => $dt,
                    'organization_id' => $orgId,
                    'category_id' => $catIds[$name],
                    'monthly_financial_control_id' => $mfcId,
                    'fixed' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // expenses: split 1500 across expense categories
            $amt2 = 1500.00 / count($expenseCats);
            foreach ($expenseCats as $name) {
                $dt = $date->copy()->addDays(5)->format('Y-m-d');
                DB::table('expenses')->insert([
                    'name' => $name,
                    'amount' => round($amt2,2),
                    'transaction_date' => $dt,
                    'paid' => true,
                    'paid_at' => $dt,
                    'organization_id' => $orgId,
                    'category_id' => $catIds[$name],
                    'monthly_financial_control_id' => $mfcId,
                    'fixed' => in_array($name,['Investimentos']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }        }

        $this->command->info('Financial demo data inserted for 3 months.');
    }
}
