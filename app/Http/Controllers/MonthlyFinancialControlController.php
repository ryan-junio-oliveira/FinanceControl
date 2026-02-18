<?php

namespace App\Http\Controllers;

use App\Models\MonthlyFinancialControl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MonthlyFinancialControlController extends Controller
{
    public function index()
    {
        $controls = MonthlyFinancialControl::where('organization_id', Auth::user()->organization_id)
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->paginate(10);
        return view('monthly-controls.index', compact('controls'));
    }

    public function create()
    {
        return view('monthly-controls.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2000|max:2100',
        ]);
        $validated['organization_id'] = Auth::user()->organization_id;
        MonthlyFinancialControl::create($validated);
        return redirect()->route('monthly-controls.index')->with('success', 'Controle mensal criado com sucesso!');
    }

    public function edit(MonthlyFinancialControl $monthly_control)
    {
        return view('monthly-controls.edit', ['control' => $monthly_control]);
    }

    public function update(Request $request, MonthlyFinancialControl $monthly_control)
    {
        $validated = $request->validate([
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2000|max:2100',
        ]);
        $monthly_control->update($validated);
        return redirect()->route('monthly-controls.index')->with('success', 'Controle mensal atualizado com sucesso!');
    }

    public function destroy(MonthlyFinancialControl $monthly_control)
    {
        $monthly_control->delete();
        return redirect()->route('monthly-controls.index')->with('success', 'Controle mensal removido com sucesso!');
    }
}
