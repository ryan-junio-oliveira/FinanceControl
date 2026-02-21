<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Models\User;
use Carbon\Carbon;

class DashboardBudgetImpactTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_without_budget_selected_has_no_impact_data()
    {
        $orgId = DB::table('organizations')->insertGetId(['name' => 'Org X']);
        $user = User::factory()->create(['organization_id' => $orgId]);
        $this->actingAs($user);

        $response = $this->get('/dashboard');
        $response->assertStatus(200);
        $response->assertViewIs('dashboard');
        $response->assertViewHas('selectedBudget', null);
        $response->assertViewHas('budgetImpact', null);
        // ensure breakdown keys exist (should default to zero)
        $response->assertViewHas('fixedRecipes', 0);
        $response->assertViewHas('variableRecipes', 0);
        $response->assertViewHas('fixedExpenses', 0);
        $response->assertViewHas('variableExpenses', 0);
        $response->assertViewHas('cardsSeries', function ($a) {
            // debug if something unexpected
            if (!is_array($a) || abs(array_sum($a)) > 0.0001) {
                dump('cardsSeries debug', $a);
            }
            return is_array($a) && abs(array_sum($a)) < 0.0001;
        });
        $response->assertViewHas('monthlyCategories');
        // new paid/received totals should start zero
        $response->assertViewHas('totalExpensesPaid', 0);
        $response->assertViewHas('totalRecipesReceived', 0);
        $response->assertViewHas('cardsPaid', 0);

        // ------------------------------------------------------------------
        // verify card series respects monthly control presence
        // ------------------------------------------------------------------
        // add a credit card and two monthly controls spaced three months apart
        $bankId = DB::table('banks')->insertGetId(['name' => 'Test Bank']);
        DB::table('credit_cards')->insert([
            'name' => 'Card A',
            'bank_id' => $bankId,
            'bank' => 'Test Bank',
            'statement_amount' => 100.00,
            'organization_id' => $orgId,
        ]);
        $today = Carbon::now();
        $firstMonth = $today->copy()->subMonths(2);
        $secondMonth = $today->copy()->subMonths(1);
        DB::table('monthly_financial_controls')->insertGetId([
            'organization_id' => $orgId,
            'month' => $firstMonth->month,
            'year' => $firstMonth->year,
        ]);
        DB::table('monthly_financial_controls')->insertGetId([
            'organization_id' => $orgId,
            'month' => $secondMonth->month,
            'year' => $secondMonth->year,
        ]);
        $resp2 = $this->get('/dashboard');
        $resp2->assertViewHas('cardsSeries', function ($series) {
            // should have exactly two non-zero entries
            return is_array($series) && count(array_filter($series)) === 2;
        });

        // ------------------------------------------------------------------
        // verify default behaviours on models
        // ------------------------------------------------------------------
        // create an expense category to satisfy foreign key
        $catId = DB::table('categories')->insertGetId([
            'name' => 'Misc',
            'type' => 'expense',
            'organization_id' => $orgId,
        ]);
        // expense without date should get today's date and unpaid
        $exp = \App\Modules\Expense\Infrastructure\Persistence\Eloquent\ExpenseModel::create([
            'name' => 'Teste',
            'amount' => 123,
            'organization_id' => $orgId,
            'category_id' => $catId,
        ]);
        $this->assertDatabaseHas('expenses', [
            'id' => $exp->id,
            'paid' => false,
        ]);
        $this->assertEquals(now()->format('Y-m-d'),
            Carbon::parse(DB::table('expenses')->where('id', $exp->id)->value('transaction_date'))->format('Y-m-d')
        );

        // recipe without date should get today's date and not received
        // we can reuse same $catId but change its type to recipe or create new
        $recCat = DB::table('categories')->insertGetId([
            'name' => 'Incomes',
            'type' => 'recipe',
            'organization_id' => $orgId,
        ]);
        $rec = \App\Modules\Recipe\Infrastructure\Persistence\Eloquent\RecipeModel::create([
            'name' => 'TesteR',
            'amount' => 456,
            'organization_id' => $orgId,
            'category_id' => $recCat,
        ]);
        $this->assertDatabaseHas('recipes', [
            'id' => $rec->id,
            'received' => false,
        ]);
        $this->assertEquals(now()->format('Y-m-d'),
            Carbon::parse(DB::table('recipes')->where('id', $rec->id)->value('transaction_date'))->format('Y-m-d')
        );
    }

    public function test_dashboard_displays_budget_impact_when_budget_selected()
    {
        $orgId = DB::table('organizations')->insertGetId(['name' => 'Org Y']);
        $user = User::factory()->create(['organization_id' => $orgId]);
        $this->actingAs($user);

        $catId = DB::table('categories')->insertGetId([
            'name' => 'Alimentação',
            'type' => 'expense',
            'organization_id' => $orgId,
        ]);

        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();

        // create a credit card so the pie charts and category slice include it
        $bankId = DB::table('banks')->insertGetId(['name' => 'X Bank']);
        $cardId = DB::table('credit_cards')->insertGetId([
            'name' => 'Cartão Teste',
            'bank_id' => $bankId,
            'bank' => 'X Bank',
            'statement_amount' => 250.00,
            'organization_id' => $orgId,
        ]);

        // monthly control just for FK requirements
        $mfcId = DB::table('monthly_financial_controls')->insertGetId([
            'organization_id' => $orgId,
            'month' => $start->month,
            'year' => $start->year,
        ]);

        // expense within budget period (should be counted)
        DB::table('expenses')->insert([
            'name' => 'Supermercado',
            'amount' => 200.00,
            'transaction_date' => $start->copy()->addDays(3)->format('Y-m-d'),
            'organization_id' => $orgId,
            'category_id' => $catId,
            'monthly_financial_control_id' => $mfcId,
        ]);

        // expense outside budget period (should be ignored)
        $mfcNext = DB::table('monthly_financial_controls')->insertGetId([
            'organization_id' => $orgId,
            'month' => $end->copy()->addMonth()->month,
            'year' => $end->copy()->addMonth()->year,
        ]);
        DB::table('expenses')->insert([
            'name' => 'Cinema',
            'amount' => 150.00,
            'transaction_date' => $end->copy()->addMonth()->format('Y-m-d'),
            'organization_id' => $orgId,
            'category_id' => $catId,
            'monthly_financial_control_id' => $mfcNext,
        ]);

        $budgetId = DB::table('budgets')->insertGetId([
            'organization_id' => $orgId,
            'name' => 'Orçamento Mensal',
            'amount' => 500.00,
            'start_date' => $start->format('Y-m-d'),
            'end_date' => $end->format('Y-m-d'),
            'category_id' => $catId,
        ]);

        $response = $this->get('/dashboard?budget_id=' . $budgetId);
        $response->assertStatus(200);
        $response->assertViewIs('dashboard');
        // card appear as its own category slice
        $response->assertViewHas('expensesCategoryLabels', function ($labels) {
            return is_array($labels) && in_array('Cartões', $labels);
        });
        // comparison data available
        $response->assertViewHas('budgetComparison', function ($c) {
            return is_array($c) && array_key_exists('actual',$c) && array_key_exists('predicted',$c);
        });

        $response->assertViewHas('selectedBudget', function ($b) use ($budgetId) {
            return $b && $b->id === $budgetId;
        });

        $response->assertViewHas('budgetImpact', function ($impact) {
            return is_array($impact)
                && $impact['planned'] === 500.00
                && $impact['spent'] === 200.00
                && $impact['percent'] === 40.0;
        });

        // add some receipts/expenses to check breakdown
        // we previously inserted $200 expense; add a fixed recipe and variable recipe
        DB::table('recipes')->insert([
            'name' => 'Salario',
            'amount' => 1000.00,
            'transaction_date' => $start->copy()->addDays(1)->format('Y-m-d'),
            'organization_id' => $orgId,
            'category_id' => $catId,
            'monthly_financial_control_id' => $mfcId,
            'fixed' => 1,
        ]);
        DB::table('recipes')->insert([
            'name' => 'Freelance',
            'amount' => 300.00,
            'transaction_date' => $start->copy()->addDays(2)->format('Y-m-d'),
            'organization_id' => $orgId,
            'category_id' => $catId,
            'monthly_financial_control_id' => $mfcId,
            'fixed' => 0,
        ]);

        $response = $this->get('/dashboard?budget_id=' . $budgetId);
        $response->assertViewHas('fixedRecipes', 1000.00);
        $response->assertViewHas('variableRecipes', 300.00);
        $response->assertViewHas('fixedExpenses', 0.00);
        $response->assertViewHas('variableExpenses', 200.00); // only the in‑period expense
    }
}
