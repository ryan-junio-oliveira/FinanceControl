<?php

namespace App\Modules\Shared\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Expense\Infrastructure\Persistence\Eloquent\ExpenseModel as Expense;
use App\Modules\Recipe\Infrastructure\Persistence\Eloquent\RecipeModel as Recipe;
use App\Modules\CreditCard\Infrastructure\Persistence\Eloquent\CreditCardModel as CreditCard;
use App\Modules\Budget\Domain\Contracts\BudgetRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;

        $orgId = Auth::user()?->organization_id;

        [$months, $monthlyCategories] = $this->buildMonthWindow();

        if (!$orgId) {
            return $this->emptyDashboard($monthlyCategories);
        }

        $totals = $this->getCurrentMonthTotals($orgId);

        $monthlySeries = $this->getMonthlySeries($orgId, $months);

        $recentTransactions = $this->getRecentTransactions($orgId);

        // Expenses by category (current month)
        $expensesByCategory = Expense::selectRaw('categories.name AS category, SUM(expenses.amount) AS total')
            ->join('categories', 'categories.id', '=', 'expenses.category_id')
            ->where('expenses.organization_id', $orgId)
            ->where('categories.name', '<>', 'Investimentos')
            ->whereYear('expenses.transaction_date', now()->year)
            ->whereMonth('expenses.transaction_date', now()->month)
            ->groupBy('categories.name')
            ->orderByDesc('total')
            ->get();


        // Recipes by category (current month)
        $recipesByCategory = Recipe::selectRaw('categories.name AS category, SUM(recipes.amount) AS total')
            ->join('categories', 'categories.id', '=', 'recipes.category_id')
            ->where('recipes.organization_id', $orgId)
            ->where('categories.type','recipe')
            ->whereYear('recipes.transaction_date', now()->year)
            ->whereMonth('recipes.transaction_date', now()->month)
            ->groupBy('categories.name')
            ->orderByDesc('total')
            ->get();

        // Cards summary calculated from expenses linked to cards
        $cardSumsCurrent = Expense::where('organization_id', $orgId)
            ->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->whereNotNull('credit_card_id')
            ->groupBy('credit_card_id')
            ->pluck(DB::raw('SUM(amount)'), 'credit_card_id');

        $creditCards = CreditCard::where('organization_id', $orgId)->with('bank')->get();
        // overwrite statement_amount with actual sums for the month, but fall back
        // to the configured value when there are no expenses (i.e. card was just
        // created and no transactions yet).
        $creditCards = $creditCards->map(function ($c) use ($cardSumsCurrent) {
            $original = $c->statement_amount;
            $c->statement_amount = $cardSumsCurrent[$c->id] ?? $original;
            return $c;
        });

        $cardsTotal = $creditCards->sum('statement_amount');

        // add slice for cards if any
        if ($cardsTotal > 0) {
            $expensesByCategory->push((object)[
                'category' => 'Cartões',
                'total' => $cardsTotal,
            ]);
        }

        // Combined expense (expenses this month + cards amounts)
        $totalExpensesWithCards = ($totals['totalExpenses'] ?? 0) + $cardsTotal;

        // Prepare chart-friendly arrays
        $expensesCategoryLabels = $expensesByCategory->pluck('category')->toArray();
        $expensesCategorySeries = $expensesByCategory->pluck('total')->map(fn($v) => (float) $v)->toArray();

        $recipesCategoryLabels = $recipesByCategory->pluck('category')->toArray();
        $recipesCategorySeries = $recipesByCategory->pluck('total')->map(fn($v) => (float) $v)->toArray();

        // Combined small-series for current month (prepared server-side to avoid complex inline Blade arrays)
        $combinedChartLabels = [ now()->format('M/Y') ];
        $combinedChartSeries = [
            [ 'name' => 'Receitas', 'data' => [ (float) ($totals['totalRecipes'] ?? 0) ] ],
            [ 'name' => 'Despesas + Cartões', 'data' => [ (float) $totalExpensesWithCards ] ],
        ];

        // when rendering monthly graphs, we want a parallel series of card totals
        // only show values for months where we actually have a financial control record
        $mfcMonths = DB::table('monthly_financial_controls')
            ->where('organization_id', $orgId)
            ->get(['year','month'])
            ->map(fn($r) => sprintf('%04d-%02d', $r->year, $r->month))
            ->toArray();

        $cardsSeries = $months->map(function($date) use ($orgId, $mfcMonths) {
            if (in_array($date->format('Y-m'), $mfcMonths)) {
                return Expense::where('organization_id', $orgId)
                    ->whereYear('transaction_date', $date->year)
                    ->whereMonth('transaction_date', $date->month)
                    ->whereNotNull('credit_card_id')
                    ->sum('amount');
            }
            return 0;
        })->toArray();

        // Top expense categories (for bar chart)
        $topExpenseCategories = $expensesByCategory->take(5)->map(fn($r) => ['category' => $r->category, 'total' => (float) $r->total]);

        // Top recipe (revenue) categories
        $topRecipeCategories = $recipesByCategory->take(5)->map(fn($r) => ['category' => $r->category, 'total' => (float) $r->total]);

        // Daily expenses — current month, grouped by day
        $dailyExpenses = Expense::where('organization_id', $orgId)
            ->whereYear('transaction_date', now()->year)
            ->whereMonth('transaction_date', now()->month)
            ->get(['transaction_date', 'amount'])
            ->groupBy(fn($e) => Carbon::parse($e->transaction_date)->day)
            ->map(fn($group) => $group->sum('amount'))
            ->sortKeys();

        $daysInMonth   = now()->daysInMonth;
        $dailyLabels   = range(1, $daysInMonth);
        $dailyData     = array_map(fn($d) => (float) ($dailyExpenses[$d] ?? 0), $dailyLabels);

        // Cumulative daily expenses (to show spending pace vs the month)
        $cumulative = 0;
        $dailyCumulative = array_map(function ($v) use (&$cumulative) {
            $cumulative += $v;
            return round($cumulative, 2);
        }, $dailyData);

        // Top 3 expense categories trend — last 6 months
        $top3Categories = $expensesByCategory->take(3)->pluck('category')->toArray();

        $trendStart = now()->subMonths(5)->startOfMonth();
        $trendEnd   = now()->endOfMonth();

        $trendMonths = collect(range(0, 5))
            ->map(fn($i) => $trendStart->copy()->addMonths($i));
        $trendLabels = $trendMonths->map(fn($d) => $d->format('M/Y'))->toArray();

        $trendSeries = [];
        if (count($top3Categories) > 0) {
            // Fetch raw rows and aggregate in PHP — avoids YEAR()/MONTH() which are MySQL-only
            $trendExpenses = Expense::select('categories.name AS category', 'expenses.amount', 'expenses.transaction_date')
                ->join('categories', 'categories.id', '=', 'expenses.category_id')
                ->where('expenses.organization_id', $orgId)
                ->whereIn('categories.name', $top3Categories)
                ->whereBetween('expenses.transaction_date', [$trendStart, $trendEnd])
                ->get();

            foreach ($top3Categories as $cat) {
                $data = [];
                foreach ($trendMonths as $date) {
                    $total = $trendExpenses
                        ->filter(fn($r) => $r->category === $cat
                            && Carbon::parse($r->transaction_date)->year  === $date->year
                            && Carbon::parse($r->transaction_date)->month === $date->month)
                        ->sum('amount');
                    $data[] = round((float) $total, 2);
                }
                $trendSeries[] = ['name' => $cat, 'data' => $data];
            }
        }

        // Budgets available for dashboard dropdown (active budgets overlapping current month)
        $monthStart = now()->startOfMonth();
        $monthEnd = now()->endOfMonth();

        $availableBudgets = \App\Modules\Budget\Infrastructure\Persistence\Eloquent\BudgetModel::where('organization_id', $orgId)
            ->where('is_active', true)
            ->whereDate('start_date', '<=', $monthEnd)
            ->whereDate('end_date', '>=', $monthStart)
            ->orderByDesc('amount')
            ->get();

        // compute corrected balance before using it for budget comparison
        $correctedBalance = ($totals['totalRecipes'] ?? 0) - ($totals['totalExpenses'] ?? 0) - $cardsTotal;

        // compute selected budget impact if requested
        $selectedBudget = null;
        $budgetImpact = null;
        $budgetComparison = null;
        if ($request->filled('budget_id')) {
            $b = $availableBudgets->firstWhere('id', $request->budget_id);
            if ($b) {
                $selectedBudget = $b;
                $repo = app(BudgetRepositoryInterface::class);
                $spent = $repo->calculateSpent(
                    new \App\Modules\Budget\Domain\Entities\Budget(
                        $b->id,
                        $b->name,
                        (float) $b->amount,
                        new \DateTime($b->start_date),
                        new \DateTime($b->end_date),
                        $b->category_id,
                        (bool) $b->is_active,
                        $b->organization_id
                    )
                );

                $budgetImpact = [
                    'planned' => (float) $b->amount,
                    'spent' => $spent,
                    'percent' => $b->amount ? round(($spent / $b->amount) * 100, 2) : 0,
                ];

                // comparison data: current corrected balance vs remaining budget
                $budgetComparison = [
                    'actual' => $correctedBalance,
                    'predicted' => (float) $b->amount - $spent,
                ];
            }
        }

        // Correct balance already computed above
        // $correctedBalance = ($totals['totalRecipes'] ?? 0) - ($totals['totalExpenses'] ?? 0) - $cardsTotal;

        return view('dashboard', [
            ...$totals,
            'balance'            => $correctedBalance,
            'recentTransactions' => $recentTransactions,
            'monthlyCategories' => $monthlyCategories,
            'monthlySeries' => $monthlySeries,

            // category breakdowns
            'expensesByCategory' => $expensesByCategory,
            'recipesByCategory' => $recipesByCategory,
            'expensesCategoryLabels' => $expensesCategoryLabels,
            'expensesCategorySeries' => $expensesCategorySeries,
            'recipesCategoryLabels' => $recipesCategoryLabels,
            'recipesCategorySeries' => $recipesCategorySeries,

            // cards
            'creditCards' => $creditCards,
            'cardsTotal' => $cardsTotal,
            'totalExpensesWithCards' => $totalExpensesWithCards,

            // combined chart
            'combinedChartLabels' => $combinedChartLabels,
            'combinedChartSeries' => $combinedChartSeries,

            'topExpenseCategories' => $topExpenseCategories,
            'topRecipeCategories' => $topRecipeCategories,

            // daily expenses
            'dailyLabels'     => $dailyLabels,
            'dailyData'       => $dailyData,
            'dailyCumulative' => $dailyCumulative,

            // top categories trend
            'trendLabels' => $trendLabels,
            'trendSeries' => $trendSeries,
            'cardsSeries' => $cardsSeries,

            // Budgets for selection and impact
            'availableBudgets' => $availableBudgets,
            'selectedBudget' => $selectedBudget,
            'budgetImpact' => $budgetImpact,
            'budgetComparison' => $budgetComparison,
        ]);
    }

    /**
     * Constrói janela dos últimos 12 meses.
     */
    private function buildMonthWindow(): array
    {
        $start = now()->subMonths(11)->startOfMonth();

        $months = collect(range(0, 11))
            ->map(fn($i) => $start->copy()->addMonths($i));

        $categories = $months
            ->map(fn($date) => $date->format('M/Y'))
            ->toArray();

        return [$months, $categories];
    }

    /**
     * Retorno padrão quando não há organização.
     */
    private function emptyDashboard(array $categories)
    {
        $zeroSeries = array_fill(0, 12, 0);

        return view('dashboard', [
            'totalRecipes'           => 0,
            'totalExpenses'          => 0,
            'balance'                => 0,
            // 'executionPercent'       => 0,
            'recentTransactions'     => collect(),
            'monthlyCategories'      => $categories,
            'monthlySeries'          => [
                ['name' => 'Receitas', 'data' => $zeroSeries],
                ['name' => 'Despesas', 'data' => $zeroSeries],
            ],
            'expensesCategoryLabels' => [],
            'expensesCategorySeries' => [],
            'recipesCategoryLabels'  => [],
            'recipesCategorySeries'  => [],
            'topExpenseCategories'   => collect(),
            'topRecipeCategories'    => collect(),
            'totalInvestments'        => 0,
            'creditCards'            => collect(),
            'cardsTotal'             => 0,
            'totalExpensesWithCards' => 0,
            'dailyLabels'            => range(1, now()->daysInMonth),
            'dailyData'              => array_fill(0, now()->daysInMonth, 0),
            'dailyCumulative'        => array_fill(0, now()->daysInMonth, 0),
            'trendLabels'            => [],
            'trendSeries'            => [],
            'cardsSeries'            => [],

            // budgets (none when there is no org)
            'availableBudgets' => collect(),
            'selectedBudget' => null,
            'budgetImpact' => null,
        ]);
    }

    /**
     * Totais do mês atual.
     */
    private function getCurrentMonthTotals(int $orgId): array
    {
        $month = now()->month;
        $year = now()->year;

        // receitas (somente categorias do tipo recipe)
        $totalRecipes = Recipe::join('categories','categories.id','=','recipes.category_id')
            ->where('recipes.organization_id', $orgId)
            ->where('categories.type','recipe')
            ->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->sum('recipes.amount');

        $fixedRecipes = Recipe::join('categories','categories.id','=','recipes.category_id')
            ->where('recipes.organization_id', $orgId)
            ->where('categories.type','recipe')
            ->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->where('recipes.fixed', true)
            ->sum('recipes.amount');

        $variableRecipes = $totalRecipes - $fixedRecipes;

        // despesas
        $totalExpenses = Expense::where('organization_id', $orgId)
            ->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->sum('amount');

        $fixedExpenses = Expense::where('organization_id', $orgId)
            ->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->where('fixed', true)
            ->sum('amount');

        $variableExpenses = $totalExpenses - $fixedExpenses;

        // investimentos agora têm sua própria tabela
        $totalInvestments = \App\Modules\Investment\Infrastructure\Persistence\Eloquent\InvestmentModel::
            where('organization_id', $orgId)
            ->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->sum('amount');

        // paid/received subtotals for liveliness
        $totalRecipesReceived = Recipe::where('organization_id', $orgId)
            ->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->where('received', true)
            ->sum('amount');

        $totalExpensesPaid = Expense::where('organization_id', $orgId)
            ->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->where('paid', true)
            ->sum('amount');

        $cardsPaid = CreditCard::where('organization_id', $orgId)
            ->where('paid', true)
            ->sum('statement_amount');

        $balance = $totalRecipesReceived - $totalExpensesPaid - $cardsPaid;

        return [
            'totalRecipes'      => $totalRecipes,
            'fixedRecipes'      => (float) $fixedRecipes,
            'variableRecipes'   => (float) $variableRecipes,
            'totalRecipesReceived' => (float) $totalRecipesReceived,
            'totalExpenses'     => $totalExpenses,
            'fixedExpenses'     => (float) $fixedExpenses,
            'variableExpenses'  => (float) $variableExpenses,
            'totalExpensesPaid' => (float) $totalExpensesPaid,
            'totalInvestments'  => (float) $totalInvestments,
            'cardsPaid'         => (float) $cardsPaid,
            'balance'           => $balance,
        ];
    }

    /**
     * Séries mensais agregadas (2 queries).
     */
    private function getMonthlySeries(int $orgId, $months): array
    {
        $start = $months->first()->copy()->startOfMonth();
        $end = $months->last()->copy()->endOfMonth();

        // Busca tudo em um único range
        $recipes = Recipe::where('organization_id', $orgId)
            ->whereBetween('transaction_date', [$start, $end])
            ->get(['transaction_date', 'amount']);

        $expenses = Expense::where('organization_id', $orgId)
            ->whereBetween('transaction_date', [$start, $end])
            ->get(['transaction_date', 'amount']);

        // Inicializa mapa de meses
        $incomeMap = [];
        $expenseMap = [];

        foreach ($months as $date) {
            $key = $date->format('Y-m');
            $incomeMap[$key] = 0;
            $expenseMap[$key] = 0;
        }

        // Agrupa em memória (compatível com qualquer banco)
        foreach ($recipes as $r) {
            $key = Carbon::parse($r->transaction_date)->format('Y-m');
            if (isset($incomeMap[$key])) {
                $incomeMap[$key] += (float) $r->amount;
            }
        }

        foreach ($expenses as $e) {
            $key = Carbon::parse($e->transaction_date)->format('Y-m');
            if (isset($expenseMap[$key])) {
                $expenseMap[$key] += (float) $e->amount;
            }
        }

        return [
            [
                'name' => 'Receitas',
                'data' => array_values($incomeMap),
            ],
            [
                'name' => 'Despesas',
                'data' => array_values($expenseMap),
            ],
        ];
    }

    /**
     * Últimas transações unificadas.
     */
    private function getRecentTransactions(int $orgId)
    {
        $recipes = Recipe::where('organization_id', $orgId)
            ->select(['name', 'amount', 'transaction_date', 'created_at'])
            ->latest(DB::raw('COALESCE(transaction_date, created_at)'))
            ->limit(6)
            ->get()
            ->map(fn($r) => [
                'type' => 'income',
                'name' => $r->name,
                'amount' => $r->amount,
                'date' => $r->transaction_date ?? $r->created_at,
            ]);

        $expenses = Expense::where('organization_id', $orgId)
            ->select(['name', 'amount', 'transaction_date', 'created_at'])
            ->latest(DB::raw('COALESCE(transaction_date, created_at)'))
            ->limit(6)
            ->get()
            ->map(fn($e) => [
                'type' => 'expense',
                'name' => $e->name,
                'amount' => $e->amount,
                'date' => $e->transaction_date ?? $e->created_at,
            ]);

        // ensure we are working with a plain support collection since elements
        // are simple arrays (not models) and Eloquent\Collection->merge would
        // attempt to call getKey() on each item.
        return collect($recipes->all())
            ->merge($expenses->all())
            ->sortByDesc('date')
            ->take(5)
            ->values();
    }
}
