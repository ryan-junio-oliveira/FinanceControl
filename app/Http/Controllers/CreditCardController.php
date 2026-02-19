<?php

namespace App\Http\Controllers;

use App\Enums\BankEnum;
use App\Models\Bank;
use App\Models\CreditCard;
use Illuminate\Http\Request;

class CreditCardController extends Controller
{
    public function index()
    {
        $orgId = auth()->user()->organization_id;
        $cards = CreditCard::where('organization_id', $orgId)->with('bank')->orderBy('name')->paginate(20);
        return view('credit-cards.index', ['creditCards' => $cards]);
    }

    public function create()
    {
        $banks       = Bank::orderBy('name')->get();
        $bankOptions = BankEnum::forSelect();
        return view('credit-cards.create', compact('banks', 'bankOptions'));
    }

    public function store(Request $request)
    {
        $orgId = auth()->user()->organization_id;

        $validated = $request->validate([
            'name' => 'required|string|max:191',
            'bank_id' => 'required|exists:banks,id',
            'statement_amount' => 'required|numeric|min:0',
            'limit' => 'nullable|numeric|min:0',
            'closing_day' => 'nullable|integer|between:1,31',
            'due_day' => 'nullable|integer|between:1,31',
            'color' => ['nullable','regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['organization_id'] = $orgId;
        $validated['is_active'] = (bool) ($validated['is_active'] ?? true);
        $validated['bank'] = Bank::find($validated['bank_id'])->name ?? null;

        CreditCard::create($validated);

        return redirect()->route('credit-cards.index')->with('success', 'Cartão criado com sucesso.');
    }

    public function edit(CreditCard $creditCard)
    {
        abort_unless($creditCard->organization_id === auth()->user()->organization_id, 404);
        $banks       = Bank::orderBy('name')->get();
        $bankOptions = BankEnum::forSelect();
        return view('credit-cards.edit', compact('creditCard', 'banks', 'bankOptions'));
    }

    public function update(Request $request, CreditCard $creditCard)
    {
        abort_unless($creditCard->organization_id === auth()->user()->organization_id, 404);

        $validated = $request->validate([
            'name' => 'required|string|max:191',
            'bank_id' => 'required|exists:banks,id',
            'statement_amount' => 'required|numeric|min:0',
            'limit' => 'nullable|numeric|min:0',
            'closing_day' => 'nullable|integer|between:1,31',
            'due_day' => 'nullable|integer|between:1,31',
            'color' => ['nullable','regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['is_active'] = (bool) ($validated['is_active'] ?? false);
        $validated['bank'] = Bank::find($validated['bank_id'])->name ?? null;

        $creditCard->update($validated);

        return redirect()->route('credit-cards.index')->with('success', 'Cartão atualizado.');
    }

    public function destroy(CreditCard $creditCard)
    {
        abort_unless($creditCard->organization_id === auth()->user()->organization_id, 404);
        $creditCard->delete();
        return redirect()->route('credit-cards.index')->with('success', 'Cartão removido.');
    }
}
