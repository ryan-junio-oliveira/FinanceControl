<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Recipe;
use App\Models\Expense;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $orgId = $user->organization_id;

        // fallback: se usuário não tem organização, retorna zeros (segurança)
        if (! $orgId) {
            return view('dashboard', [
                'totalRecipes' => 0,
                'totalExpenses' => 0,
                'balance' => 0,
                'executionPercent' => 0,
                'recentTransactions' => collect(),
            ]);
        }

        $month = now()->month;
        $year = now()->year;

        // Totais do mês atual (usa transaction_date)
        $totalRecipes = Recipe::where('organization_id', $orgId)
            ->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->sum('amount');

        $totalExpenses = Expense::where('organization_id', $orgId)
            ->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->sum('amount');

        $balance = $totalRecipes - $totalExpenses;

        // execução mensal: despesas / receitas (limitar 0-100)
        if ($totalRecipes > 0) {
            $executionPercent = (int) round(min(100, ($totalExpenses / $totalRecipes) * 100));
        } else {
            $executionPercent = $totalExpenses > 0 ? 100 : 0;
        }

        // últimas transações (unindo receitas + despesas e ordenando por data)
        $recentRecipes = Recipe::where('organization_id', $orgId)
            ->select(['id', 'name', 'amount', 'transaction_date', 'created_at'])
            ->orderByDesc(DB::raw('COALESCE(transaction_date, created_at)'))
            ->take(6)
            ->get()
            ->map(function ($r) {
                return [
                    'type' => 'income',
                    'name' => $r->name,
                    'amount' => $r->amount,
                    'date' => $r->transaction_date ? Carbon::parse($r->transaction_date) : $r->created_at,
                ];
            });

        $recentExpenses = Expense::where('organization_id', $orgId)
            ->select(['id', 'name', 'amount', 'transaction_date', 'created_at'])
            ->orderByDesc(DB::raw('COALESCE(transaction_date, created_at)'))
            ->take(6)
            ->get()
            ->map(function ($e) {
                return [
                    'type' => 'expense',
                    'name' => $e->name,
                    'amount' => $e->amount,
                    'date' => $e->transaction_date ? Carbon::parse($e->transaction_date) : $e->created_at,
                ];
            });

        $recentTransactions = $recentRecipes->merge($recentExpenses)
            ->sortByDesc('date')
            ->take(5)
            ->values();

        return view('dashboard', compact('totalRecipes', 'totalExpenses', 'balance', 'executionPercent', 'recentTransactions'));
    }
}
