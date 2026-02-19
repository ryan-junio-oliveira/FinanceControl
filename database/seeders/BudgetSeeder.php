<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Organization;
use App\Models\Budget;
use App\Models\Category;
use Carbon\Carbon;

class BudgetSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Organization::all() as $org) {
            $expenseCat = Category::where('organization_id', $org->id)->where('type', 'expense')->first();

            Budget::firstOrCreate([
                'organization_id' => $org->id,
                'name' => 'Moradia - mês atual',
            ], [
                'amount' => 2500.00,
                'start_date' => Carbon::now()->startOfMonth()->format('Y-m-d'),
                'end_date' => Carbon::now()->endOfMonth()->format('Y-m-d'),
                'category_id' => $expenseCat?->id,
            ]);

            Budget::firstOrCreate([
                'organization_id' => $org->id,
                'name' => 'Despesas variáveis - mês atual',
            ], [
                'amount' => 1200.00,
                'start_date' => Carbon::now()->startOfMonth()->format('Y-m-d'),
                'end_date' => Carbon::now()->endOfMonth()->format('Y-m-d'),
                'category_id' => null,
            ]);
        }
    }
}
