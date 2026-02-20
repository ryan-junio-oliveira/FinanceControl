<?php

namespace App\Http\Controllers;

use App\Enums\BankEnum;
use App\Modules\Bank\Infrastructure\Persistence\Eloquent\BankModel as Bank;
use App\Modules\CreditCard\Infrastructure\Persistence\Eloquent\CreditCardModel as CreditCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreditCardController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $orgId = Auth::user()->organization_id;
        $q = $request->query('q');
        $perPage = (int) $request->query('per_page', 20);
        $perPage = in_array($perPage, [10,20,50,100]) ? $perPage : 20;

        $query = CreditCard::where('organization_id', $orgId)->with('bank');
        if ($q) {
            $query->where('name', 'like', "%{$q}%");
        }

        $cards = $query->orderBy('name')->paginate($perPage);
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
        $orgId = Auth::user()->organization_id;

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
        abort_unless($creditCard->organization_id === Auth::user()->organization_id, 404);
        $banks       = Bank::orderBy('name')->get();
        $bankOptions = BankEnum::forSelect();
        return view('credit-cards.edit', compact('creditCard', 'banks', 'bankOptions'));
    }

    public function update(Request $request, CreditCard $creditCard)
    {
        abort_unless($creditCard->organization_id === Auth::user()->organization_id, 404);

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
        abort_unless($creditCard->organization_id === Auth::user()->organization_id, 404);
        $creditCard->delete();
        return redirect()->route('credit-cards.index')->with('success', 'Cartão removido.');
    }
}
