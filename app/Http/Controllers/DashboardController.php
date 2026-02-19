<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Recipe;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
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
            ->whereYear('expenses.transaction_date', now()->year)
            ->whereMonth('expenses.transaction_date', now()->month)
            ->groupBy('categories.name')
            ->orderByDesc('total')
            ->get();

        // Recipes by category (current month)
        $recipesByCategory = Recipe::selectRaw('categories.name AS category, SUM(recipes.amount) AS total')
            ->join('categories', 'categories.id', '=', 'recipes.category_id')
            ->where('recipes.organization_id', $orgId)
            ->whereYear('recipes.transaction_date', now()->year)
            ->whereMonth('recipes.transaction_date', now()->month)
            ->groupBy('categories.name')
            ->orderByDesc('total')
            ->get();

        // Cards summary (current organization)
        $creditCards = \App\Models\CreditCard::where('organization_id', $orgId)->get();
        $cardsTotal = $creditCards->sum('statement_amount');

        // Combined expense (expenses this month + cards statements)
        $totalExpensesWithCards = ($totals['totalExpenses'] ?? 0) + $cardsTotal;

        // Prepare chart-friendly arrays
        $expensesCategoryLabels = $expensesByCategory->pluck('category')->toArray();
        $expensesCategorySeries = $expensesByCategory->pluck('total')->map(fn($v) => (float) $v)->toArray();

        $recipesCategoryLabels = $recipesByCategory->pluck('category')->toArray();
        $recipesCategorySeries = $recipesByCategory->pluck('total')->map(fn($v) => (float) $v)->toArray();

        // Top expense categories (for bar chart)
        $topExpenseCategories = $expensesByCategory->take(5)->map(fn($r) => ['category' => $r->category, 'total' => (float) $r->total]);

        return view('dashboard', [
            ...$totals,
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

            'topExpenseCategories' => $topExpenseCategories,
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
            'totalRecipes' => 0,
            'totalExpenses' => 0,
            'balance' => 0,
            'executionPercent' => 0,
            'recentTransactions' => collect(),
            'monthlyCategories' => $categories,
            'monthlySeries' => [
                ['name' => 'Receitas', 'data' => $zeroSeries],
                ['name' => 'Despesas', 'data' => $zeroSeries],
            ],
        ]);
    }

    /**
     * Totais do mês atual.
     */
    private function getCurrentMonthTotals(int $orgId): array
    {
        $month = now()->month;
        $year = now()->year;

        $totalRecipes = Recipe::where('organization_id', $orgId)
            ->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->sum('amount');

        $totalExpenses = Expense::where('organization_id', $orgId)
            ->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->sum('amount');

        $balance = $totalRecipes - $totalExpenses;

        $executionPercent = $totalRecipes > 0
            ? (int) min(100, round(($totalExpenses / $totalRecipes) * 100))
            : ($totalExpenses > 0 ? 100 : 0);

        return [
            'totalRecipes' => $totalRecipes,
            'totalExpenses' => $totalExpenses,
            'balance' => $balance,
            'executionPercent' => $executionPercent,
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

        return $recipes
            ->merge($expenses)
            ->sortByDesc('date')
            ->take(5)
            ->values();
    }
}
