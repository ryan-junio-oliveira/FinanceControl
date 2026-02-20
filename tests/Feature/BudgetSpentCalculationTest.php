<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Models\User;
use Carbon\Carbon;
use App\Modules\Budget\Domain\Contracts\BudgetRepositoryInterface;

class BudgetSpentCalculationTest extends TestCase
{
    use RefreshDatabase;

    public function test_budget_spent_counts_expenses_and_card_expenses_within_period()
    {
        $orgId = DB::table('organizations')->insertGetId(['name' => 'Org C']);
        $user = User::factory()->create(['organization_id' => $orgId]);
        $this->actingAs($user);

        $catId = DB::table('categories')->insertGetId(['name' => 'Alimentacao', 'type' => 'expense', 'organization_id' => $orgId]);

        $bankId = DB::table('banks')->insertGetId(['name' => 'X Bank']);
        $cardId = DB::table('credit_cards')->insertGetId([
            'name' => 'Visa',
            'bank_id' => $bankId,
            'bank' => 'X Bank',
            'statement_amount' => 0,
            'organization_id' => $orgId,
        ]);


        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();

        // create a monthly control for the period so expenses can link to it
        $mfcId = DB::table('monthly_financial_controls')->insertGetId([
            'organization_id' => $orgId,
            'month' => $start->month,
            'year' => $start->year,
        ]);

        // despesas dentro do período
        DB::table('expenses')->insert([
            'name' => 'Mercado',
            'amount' => 200.00,
            'transaction_date' => $start->copy()->addDays(2)->format('Y-m-d'),
            'organization_id' => $orgId,
            'category_id' => $catId,
            'monthly_financial_control_id' => $mfcId,
        ]);

        // despesa vinculada a cartão dentro do período
        DB::table('expenses')->insert([
            'name' => 'Compras online',
            'amount' => 150.00,
            'transaction_date' => $start->copy()->addDays(5)->format('Y-m-d'),
            'organization_id' => $orgId,
            'category_id' => $catId,
            'credit_card_id' => $cardId,
            'monthly_financial_control_id' => $mfcId,
        ]);

        // despesa fora do período (create a separate monthly control for the
        // following month so the row can be inserted cleanly)
        $mfcNext = DB::table('monthly_financial_controls')->insertGetId([
            'organization_id' => $orgId,
            'month' => $end->copy()->addMonth()->month,
            'year' => $end->copy()->addMonth()->year,
        ]);

        DB::table('expenses')->insert([
            'name' => 'Viagem',
            'amount' => 500.00,
            'transaction_date' => $end->copy()->addMonth()->format('Y-m-d'),
            'organization_id' => $orgId,
            'category_id' => $catId,
            'monthly_financial_control_id' => $mfcNext,
        ]);

        $budgetId = DB::table('budgets')->insertGetId([
            'organization_id' => $orgId,
            'name' => 'Orcamento Alimentacao',
            'amount' => 1000.00,
            'start_date' => $start->format('Y-m-d'),
            'end_date' => $end->format('Y-m-d'),
            'category_id' => $catId,
        ]);

        $repo = app(BudgetRepositoryInterface::class);
        $budgetEntity = new \App\Modules\Budget\Domain\Entities\Budget(
            $budgetId,
            'Orcamento Alimentacao',
            1000.00,
            $start,
            $end,
            $catId,
            true,
            $orgId
        );

        $this->assertEquals(350.00, $repo->calculateSpent($budgetEntity));
        $this->assertEquals(35.0, 
            min(100.0, round(($repo->calculateSpent($budgetEntity) / 1000.00) * 100, 2))
        );
    }
}
