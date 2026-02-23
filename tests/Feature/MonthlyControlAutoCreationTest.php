<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Modules\Organization\Infrastructure\Persistence\Eloquent\OrganizationModel as Organization;
use App\Modules\Recipe\Infrastructure\Persistence\Eloquent\RecipeModel as Recipe;
use App\Modules\Expense\Infrastructure\Persistence\Eloquent\ExpenseModel as Expense;
use App\Modules\MonthlyFinancialControl\Infrastructure\Persistence\Eloquent\MonthlyFinancialControlModel as MonthlyFinancialControl;
use App\Modules\Admin\Infrastructure\Persistence\Eloquent\CategoryModel as Category;
use Carbon\Carbon;

class MonthlyControlAutoCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_recipe_creation_auto_creates_monthly_control()
    {
        $org = Organization::create(['name' => 'ACME Ltd']);
        $user = User::factory()->create(['organization_id' => $org->id]);

        $this->actingAs($user);

        $date = Carbon::create(2026, 2, 14);

        $cat = Category::create(['name' => 'Vendas', 'type' => 'recipe', 'organization_id' => $org->id]);

        $response = $this->post(route('recipes.store'), [
            'name' => 'Venda teste',
            'amount' => 150.00,
            'transaction_date' => $date->format('Y-m-d'),
            'category_id' => $cat->id,
        ]);

        $response->assertRedirect(route('recipes.index'));

        $this->assertDatabaseHas('monthly_financial_controls', [
            'organization_id' => $org->id,
            'month' => 2,
            'year' => 2026,
        ]);

        $recipe = Recipe::first();
        $this->assertNotNull($recipe->monthly_financial_control_id);

        $mfc = MonthlyFinancialControl::find($recipe->monthly_financial_control_id);
        $this->assertEquals(2, $mfc->month);
        $this->assertEquals(2026, $mfc->year);
    }

    public function test_expense_creation_auto_creates_monthly_control_when_not_selected()
    {
        $org = Organization::create(['name' => 'ACME Ltd']);
        $user = User::factory()->create(['organization_id' => $org->id]);

        $this->actingAs($user);

        $date = Carbon::create(2026, 3, 5);

        $cat = Category::create(['name' => 'Contas', 'type' => 'expense', 'organization_id' => $org->id]);

        $response = $this->post(route('expenses.store'), [
            'name' => 'Conta teste',
            'amount' => 75.50,
            'transaction_date' => $date->format('Y-m-d'),
            // monthly_financial_control_id intentionally omitted
            'category_id' => $cat->id,
        ]);

        $response->assertRedirect(route('expenses.index'));

        $this->assertDatabaseHas('monthly_financial_controls', [
            'organization_id' => $org->id,
            'month' => 3,
            'year' => 2026,
        ]);

        $expense = Expense::first();
        $this->assertNotNull($expense->monthly_financial_control_id);

        $mfc = MonthlyFinancialControl::find($expense->monthly_financial_control_id);
        $this->assertEquals(3, $mfc->month);
        $this->assertEquals(2026, $mfc->year);
    }
}
