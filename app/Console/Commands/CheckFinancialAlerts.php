<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Modules\Budget\Domain\Contracts\BudgetRepositoryInterface;
use App\Modules\CreditCard\Domain\Contracts\CreditCardRepositoryInterface;
use App\Modules\Budget\Infrastructure\Persistence\Eloquent\BudgetModel;
use App\Modules\CreditCard\Infrastructure\Persistence\Eloquent\CreditCardModel;
use App\Modules\Recipe\Infrastructure\Persistence\Eloquent\RecipeModel;
use App\Modules\Expense\Infrastructure\Persistence\Eloquent\ExpenseModel;

class CheckFinancialAlerts extends Command
{
    protected $signature = 'alerts:check';
    protected $description = 'Envia notificações quando orçamentos são ultrapassados, faturas estão próximas ou saldo negativo.';

    public function handle(): int
    {
        $userQuery = User::query()->whereNotNull('organization_id');
        $orgIds = $userQuery->pluck('organization_id')->unique();

        $budgetRepo = app(BudgetRepositoryInterface::class);
        $cardRepo = app(CreditCardRepositoryInterface::class);

        foreach ($orgIds as $orgId) {
            $users = User::where('organization_id', $orgId)
                ->get()
                ->filter(fn($u) => $u->hasAnyRole(['gestor', 'root']));

            // budgets - send when spent >= amount
            $budgets = BudgetModel::where('organization_id', $orgId)
                ->where('is_active', true)
                ->get();

            foreach ($budgets as $bModel) {
                $budget = $budgetRepo->findById($bModel->id);
                if (!$budget) {
                    continue;
                }
                $spent = $budgetRepo->calculateSpent($budget);
                if ($spent >= $budget->amount()) {
                    foreach ($users as $u) {
                        $u->notify(new \App\Modules\Shared\Presentation\Notifications\BudgetLimitNotification($budget, $spent));
                    }
                }
            }

            // credit cards due soon (within next 3 days)
            $cards = CreditCardModel::where('organization_id', $orgId)->get();
            $today = now()->day;
            foreach ($cards as $cModel) {
                if ($cModel->due_day === null) {
                    continue;
                }
                $due = (int)$cModel->due_day;
                if ($due >= $today && $due - $today <= 3) {
                    $card = $cardRepo->findById($cModel->id);
                    foreach ($users as $u) {
                        $u->notify(new \App\Modules\Shared\Presentation\Notifications\CreditCardDueNotification($card));
                    }
                }
            }

            // negative balance check: total expense > total income
            $totalIncome = RecipeModel::where('organization_id', $orgId)->sum('amount');
            $totalExpense = ExpenseModel::where('organization_id', $orgId)->sum('amount');
            if ($totalExpense > $totalIncome) {
                foreach ($users as $u) {
                    $u->notify(new \App\Modules\Shared\Presentation\Notifications\NegativeBalanceNotification($totalIncome, $totalExpense));
                }
            }
        }

        $this->info('Financial alerts check completed.');
        return 0;
    }
}
