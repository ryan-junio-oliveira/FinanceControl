<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Modules\Organization\Infrastructure\Persistence\Eloquent\OrganizationModel as Organization;
use App\Modules\Budget\Infrastructure\Persistence\Eloquent\BudgetModel;
use App\Modules\Expense\Infrastructure\Persistence\Eloquent\ExpenseModel;
use App\Modules\CreditCard\Infrastructure\Persistence\Eloquent\CreditCardModel;
use App\Modules\Recipe\Infrastructure\Persistence\Eloquent\RecipeModel;
use App\Modules\Admin\Infrastructure\Persistence\Eloquent\CategoryModel as Category;
use App\Modules\Admin\Infrastructure\Persistence\Eloquent\BankModel as Bank;

class AlertsCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_command_sends_budget_and_card_and_negative_notifications()
    {
        Notification::fake();

        // ensure roles exist
        $this->seed(\Database\Seeders\UserSeeder::class);

        // prepare organization and user
        $org = Organization::create(['name' => 'O']);
        $user = User::factory()->create(['organization_id' => $org->id]);
        $user->assignRole('gestor');

        // budget that will be exceeded
        $budget = BudgetModel::create([
            'name' => 'Camp',
            'amount' => 100,
            'start_date' => now()->subDays(10)->format('Y-m-d'),
            'end_date' => now()->addDays(10)->format('Y-m-d'),
            'category_id' => null,
            'is_active' => true,
            'organization_id' => $org->id,
        ]);

        // add expense above budget (must reference a category - expenses.category_id is non-nullable)
        $expenseCategory = Category::create([
            'name' => 'Alert Expense',
            'type' => 'expense',
            'organization_id' => $org->id,
        ]);

        ExpenseModel::create([
            'organization_id' => $org->id,
            'category_id' => $expenseCategory->id,
            'name' => 'Alert expense',
            'description' => null,
            'amount' => 150,
            'transaction_date' => now()->toDateString(),
        ]);

        // credit card due soon
        $bank = Bank::create([
            'name' => 'Visa Bank',
            'color' => '#000',
        ]);

        $card = CreditCardModel::create([
            'name' => 'Visa',
            'organization_id' => $org->id,
            'bank_id' => $bank->id,
            'bank' => $bank->name,
            'statement_amount' => 0,
            'limit' => null,
            'closing_day' => null,
            'due_day' => now()->addDays(2)->day,
            'is_active' => true,
            'color' => '#000',
            'paid' => false,
        ]);

        // recipe to keep negative balance
        $recipeCategory = Category::create([
            'name' => 'Alert Recipe',
            'type' => 'recipe',
            'organization_id' => $org->id,
        ]);

        RecipeModel::create([
            'organization_id' => $org->id,
            'category_id' => $recipeCategory->id,
            'name' => 'Alert recipe',
            'amount' => 10,
            'transaction_date' => now()->toDateString(),
        ]);

        // run artisan command
        $this->artisan('alerts:check')->assertExitCode(0);

        Notification::assertSentTo($user, \App\Modules\Shared\Presentation\Notifications\BudgetLimitNotification::class);
        Notification::assertSentTo($user, \App\Modules\Shared\Presentation\Notifications\CreditCardDueNotification::class);
        Notification::assertSentTo($user, \App\Modules\Shared\Presentation\Notifications\NegativeBalanceNotification::class);

        // persist notifications so the notifications page can display them
        $user->notifications()->create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'type' => \App\Modules\Shared\Presentation\Notifications\BudgetLimitNotification::class,
            'data' => ['type' => 'budget_limit', 'budget_name' => $budget->name],
        ]);
        $user->notifications()->create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'type' => \App\Modules\Shared\Presentation\Notifications\CreditCardDueNotification::class,
            'data' => ['type' => 'creditcard_due', 'card_name' => $card->name, 'due_day' => $card->due_day],
        ]);
        $user->notifications()->create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'type' => \App\Modules\Shared\Presentation\Notifications\NegativeBalanceNotification::class,
            'data' => ['type' => 'negative_balance', 'expense' => 150, 'income' => 10],
        ]);

        // verify notifications page lists them
        $this->actingAs($user)
            ->get(route('notifications'))
            ->assertStatus(200)
            ->assertSee('orçamento')
            ->assertSee('Fatura');
    }
}
