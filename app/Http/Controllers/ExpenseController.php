<?php

namespace App\Http\Controllers;


use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::where('organization_id', Auth::user()->organization_id)
            ->orderByDesc('transaction_date')
            ->paginate(10);
        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        // Buscar controles mensais da organização do usuário
        $controls = \App\Models\MonthlyFinancialControl::where('organization_id', Auth::user()->organization_id)
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->get();
        return view('expenses.create', compact('controls'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0',
            'fixed' => 'boolean',
            'transaction_date' => 'required|date',
            'monthly_financial_control_id' => [
                'nullable',
                'exists:monthly_financial_controls,id',
            ],
        ]);
        // ensure organization is set (used by the model/trait to create/find monthly control)
        $validated['organization_id'] = Auth::user()->organization_id;
        Expense::create($validated);
        return redirect()->route('expenses.index')->with('success', 'Despesa criada com sucesso!');
    }

    public function edit(Expense $expense)
    {
        // Buscar controles mensais da organização do usuário
        $controls = \App\Models\MonthlyFinancialControl::where('organization_id', Auth::user()->organization_id)
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->get();
        return view('expenses.edit', compact('expense', 'controls'));
    }

    public function update(Request $request, Expense $expense)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0',
            'fixed' => 'boolean',
            'transaction_date' => 'required|date',
            'monthly_financial_control_id' => [
                'nullable',
                'exists:monthly_financial_controls,id',
            ],
        ]);
        $expense->update($validated);
        return redirect()->route('expenses.index')->with('success', 'Despesa atualizada com sucesso!');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect()->route('expenses.index')->with('success', 'Despesa removida com sucesso!');
    }
}
