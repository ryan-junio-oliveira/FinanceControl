<?php

namespace App\Http\Controllers;

use App\Enums\BankEnum;
use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function index()
    {
        $banks = Bank::orderBy('name')->paginate(20);
        return view('banks.index', compact('banks'));
    }

    public function create()
    {
        $bankOptions = BankEnum::forSelect();
        return view('banks.create', compact('bankOptions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255|unique:banks,name',
            'color' => ['nullable', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
        ]);

        // Auto-preenche a cor oficial se o nome corresponder ao enum
        $validated['color'] ??= BankEnum::colorByName($validated['name']);

        Bank::create($validated);

        return redirect()->route('banks.index')->with('success', 'Banco criado com sucesso.');
    }

    public function edit(Bank $bank)
    {
        $bankOptions = BankEnum::forSelect();
        return view('banks.edit', compact('bank', 'bankOptions'));
    }

    public function update(Request $request, Bank $bank)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255|unique:banks,name,' . $bank->id,
            'color' => ['nullable', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
        ]);

        $validated['color'] ??= BankEnum::colorByName($validated['name']);

        $bank->update($validated);

        return redirect()->route('banks.index')->with('success', 'Banco atualizado com sucesso.');
    }

    public function destroy(Bank $bank)
    {
        if ($bank->creditCards()->exists()) {
            return back()->withErrors(['error' => 'Não é possível remover um banco que possui cartões associados.']);
        }

        $bank->delete();
        return redirect()->route('banks.index')->with('success', 'Banco removido.');
    }
}
