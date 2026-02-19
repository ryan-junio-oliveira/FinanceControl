<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    public function index()
    {
        $budgets = Budget::where('organization_id', Auth::user()->organization_id)
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('budgets.index', compact('budgets'));
    }

    public function create()
    {
        $categories = \App\Models\Category::where('organization_id', Auth::user()->organization_id)
            ->where('type', 'expense')
            ->orderBy('name')
            ->get();

        return view('budgets.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $orgId = Auth::user()->organization_id;

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'category_id' => [
                'nullable',
                'integer',
                \Illuminate\Validation\Rule::exists('categories', 'id')->where(function ($q) use ($orgId) {
                    $q->where('organization_id', $orgId)->where('type', 'expense');
                }),
            ],
            'is_active' => 'boolean',
        ]);

        $validated['organization_id'] = $orgId;
        $validated['is_active'] = $validated['is_active'] ?? true;

        Budget::create($validated);

        return redirect()->route('budgets.index')->with('success', 'Orçamento criado com sucesso.');
    }

    public function edit(Budget $budget)
    {
        abort_unless($budget->organization_id === Auth::user()->organization_id, 404);

        $categories = \App\Models\Category::where('organization_id', Auth::user()->organization_id)
            ->where('type', 'expense')
            ->orderBy('name')
            ->get();

        return view('budgets.edit', compact('budget', 'categories'));
    }

    public function update(Request $request, Budget $budget)
    {
        abort_unless($budget->organization_id === Auth::user()->organization_id, 404);

        $orgId = Auth::user()->organization_id;

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'category_id' => [
                'nullable',
                'integer',
                \Illuminate\Validation\Rule::exists('categories', 'id')->where(function ($q) use ($orgId) {
                    $q->where('organization_id', $orgId)->where('type', 'expense');
                }),
            ],
            'is_active' => 'boolean',
        ]);

        $budget->update($validated);

        return redirect()->route('budgets.index')->with('success', 'Orçamento atualizado.');
    }

    public function show(Budget $budget)
    {
        abort_unless($budget->organization_id === Auth::user()->organization_id, 404);
        return view('budgets.show', compact('budget'));
    }

    public function destroy(Budget $budget)
    {
        abort_unless($budget->organization_id === Auth::user()->organization_id, 404);
        $budget->delete();
        return redirect()->route('budgets.index')->with('success', 'Orçamento removido.');
    }
}
