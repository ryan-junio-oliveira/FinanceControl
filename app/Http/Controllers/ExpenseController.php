<?php

namespace App\Http\Controllers;


use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $orgId = Auth::user()->organization_id;
        $q = $request->query('q');
        $perPage = (int) $request->query('per_page', 10);
        $perPage = in_array($perPage, [10,20,50,100]) ? $perPage : 10;

        $query = Expense::where('organization_id', $orgId);

        if ($q) {
            $query->where('name', 'like', "%{$q}%");
        }

        $expenses = $query->orderByDesc('transaction_date')->paginate($perPage);
        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        // Buscar controles mensais e categorias da organização do usuário
        $controls = \App\Models\MonthlyFinancialControl::where('organization_id', Auth::user()->organization_id)
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->get();

        $categories = \App\Models\Category::where('organization_id', Auth::user()->organization_id)
            ->where('type', 'expense')
            ->orderBy('name')
            ->get();

        $creditCards = \App\Models\CreditCard::where('organization_id', Auth::user()->organization_id)->orderBy('name')->get();

        return view('expenses.create', compact('controls', 'categories', 'creditCards'));
    }

    public function store(Request $request)
    {
        $orgId = Auth::user()->organization_id;

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0',
            'fixed' => 'boolean',
            'transaction_date' => 'required|date',
            'monthly_financial_control_id' => [
                'nullable',
                'exists:monthly_financial_controls,id',
            ],
            'category_id' => [
                'required',
                'integer',
                \Illuminate\Validation\Rule::exists('categories', 'id')->where(function ($q) use ($orgId) {
                    $q->where('organization_id', $orgId)->where('type', 'expense');
                }),
            ],
            'credit_card_id' => [
                'nullable',
                'integer',
                \Illuminate\Validation\Rule::exists('credit_cards', 'id')->where(function ($q) use ($orgId) {
                    $q->where('organization_id', $orgId);
                }),
            ],
        ]);
        // ensure organization is set (used by the model/trait to create/find monthly control)
        $validated['organization_id'] = $orgId;
        Expense::create($validated);
        return redirect()->route('expenses.index')->with('success', 'Despesa criada com sucesso!');
    }

    public function edit(Expense $expense)
    {
        // Buscar controles mensais e categorias da organização do usuário
        $controls = \App\Models\MonthlyFinancialControl::where('organization_id', Auth::user()->organization_id)
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->get();

        $categories = \App\Models\Category::where('organization_id', Auth::user()->organization_id)
            ->where('type', 'expense')
            ->orderBy('name')
            ->get();

        $creditCards = \App\Models\CreditCard::where('organization_id', Auth::user()->organization_id)->orderBy('name')->get();
        return view('expenses.edit', compact('expense', 'controls', 'categories', 'creditCards'));
    }

    public function update(Request $request, Expense $expense)
    {
        $orgId = Auth::user()->organization_id;

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0',
            'fixed' => 'boolean',
            'transaction_date' => 'required|date',
            'monthly_financial_control_id' => [
                'nullable',
                'exists:monthly_financial_controls,id',
            ],
            'credit_card_id' => [
                'nullable',
                'integer',
                \Illuminate\Validation\Rule::exists('credit_cards', 'id')->where(function ($q) use ($orgId) {
                    $q->where('organization_id', $orgId);
                }),
            ],
            'category_id' => [
                'required',
                'integer',
                \Illuminate\Validation\Rule::exists('categories', 'id')->where(function ($q) use ($orgId) {
                    $q->where('organization_id', $orgId)->where('type', 'expense');
                }),
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
