<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Organization;
use App\Models\User;
use App\Models\Category;
use App\Models\Expense;
use App\Models\CreditCard;
use App\Models\Budget;
use Carbon\Carbon;

class BudgetSpentCalculationTest extends TestCase
{
    use RefreshDatabase;

    public function test_budget_spent_counts_expenses_and_card_expenses_within_period()
    {
        $org = Organization::create(['name' => 'Org C']);
        $user = User::factory()->create(['organization_id' => $org->id]);
        $this->actingAs($user);

        $cat = Category::create(['name' => 'Alimentacao', 'type' => 'expense', 'organization_id' => $org->id]);

        $card = CreditCard::create([
            'name' => 'Visa',
            'bank_id' => \App\Models\Bank::create(['name' => 'X Bank'])->id,
            'bank' => 'X Bank',
            'statement_amount' => 0,
            'organization_id' => $org->id,
        ]);

        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();

        // despesas dentro do período
        Expense::create([
            'name' => 'Mercado',
            'amount' => 200.00,
            'transaction_date' => $start->copy()->addDays(2)->format('Y-m-d'),
            'organization_id' => $org->id,
            'category_id' => $cat->id,
        ]);

        // despesa vinculada a cartão dentro do período
        Expense::create([
            'name' => 'Compras online',
            'amount' => 150.00,
            'transaction_date' => $start->copy()->addDays(5)->format('Y-m-d'),
            'organization_id' => $org->id,
            'category_id' => $cat->id,
            'credit_card_id' => $card->id,
        ]);

        // despesa fora do período
        Expense::create([
            'name' => 'Viagem',
            'amount' => 500.00,
            'transaction_date' => $end->copy()->addMonth()->format('Y-m-d'),
            'organization_id' => $org->id,
            'category_id' => $cat->id,
        ]);

        $budget = Budget::create([
            'organization_id' => $org->id,
            'name' => 'Orcamento Alimentacao',
            'amount' => 1000.00,
            'start_date' => $start->format('Y-m-d'),
            'end_date' => $end->format('Y-m-d'),
            'category_id' => $cat->id,
        ]);

        $this->assertEquals(350.00, $budget->spent());
        $this->assertEquals(35.0, $budget->progressPercent());
    }
}
