<?php

namespace App\Modules\CreditCard\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\CreditCard\Application\UseCases\ListCreditCards;
use App\Modules\CreditCard\Domain\Contracts\CreditCardRepositoryInterface;
use App\Modules\CreditCard\Presentation\Http\Requests\StoreCreditCardRequest;
use App\Modules\CreditCard\Presentation\Http\Requests\UpdateCreditCardRequest;
use App\Modules\Bank\Application\UseCases\ListBanks;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CreditCardController extends Controller
{
    private ListCreditCards $listCreditCards;
    private CreditCardRepositoryInterface $cardRepo;
    private ListBanks $listBanks;

    public function __construct(
        ListCreditCards $listCreditCards,
        CreditCardRepositoryInterface $cardRepo,
        ListBanks $listBanks
    ) {
        $this->listCreditCards = $listCreditCards;
        $this->cardRepo = $cardRepo;
        $this->listBanks = $listBanks;
    }

    public function index(Request $request)
    {
        try {
            $orgId = Auth::user()->organization_id;
            $search = $request->query('q');
            $perPage = (int) $request->query('per_page', 20);
            $perPage = in_array($perPage, [10, 20, 50, 100]) ? $perPage : 20;
            $page = $request->query('page');

            $creditCards = $this->listCreditCards->execute($orgId, $search, $perPage, $page);
            return view('credit-cards.index', compact('creditCards'));
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->with('error', 'Erro ao listar cartões.');
        }
    }

    public function create()
    {
        try {
            $orgId = Auth::user()->organization_id;
            $banks = collect($this->listBanks->execute($orgId));
            $banks = $banks->map(fn($b) => (object) ['id' => $b->id(), 'name' => $b->name()]);
            $bankOptions = \App\Enums\BankEnum::forSelect();
            return view('credit-cards.create', compact('banks', 'bankOptions'));
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->with('error', 'Erro ao carregar formulário de cartão.');
        }
    }

    public function store(StoreCreditCardRequest $request)
    {
        try {
            $orgId = Auth::user()->organization_id;

            $vals = $request->validated();
            // map validated data into domain entity
            $card = new \App\Modules\CreditCard\Domain\Entities\CreditCard(
                0,
                $vals['name'],
                $orgId,
                $vals['bank_id'],
                null,
                (float) $vals['statement_amount'],
                isset($vals['limit']) ? (float) $vals['limit'] : null,
                $vals['closing_day'] ?? null,
                $vals['due_day'] ?? null,
                (bool) ($vals['is_active'] ?? true),
                $vals['color'] ?? null
            );

            $this->cardRepo->save($card);

            return redirect()->route('credit-cards.index')->with('success', 'Cartão criado com sucesso.');
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->withInput()->with('error', 'Não foi possível criar o cartão.');
        }
    }

    public function edit($id)
    {
        try {
            $orgId = Auth::user()->organization_id;
            $card = $this->cardRepo->findById($id);
            abort_unless($card && $card->organizationId() === $orgId, 404);

            $banks = collect($this->listBanks->execute($orgId))
                ->map(fn($b) => (object) ['id' => $b->id(), 'name' => $b->name()]);
            $bankOptions = \App\Enums\BankEnum::forSelect();
            return view('credit-cards.edit', compact('card', 'banks', 'bankOptions'));
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->with('error', 'Erro ao carregar formulário de edição.');
        }
    }

    public function update(UpdateCreditCardRequest $request, $id)
    {
        try {
            $orgId = Auth::user()->organization_id;
            $existing = $this->cardRepo->findById($id);
            abort_unless($existing && $existing->organizationId() === $orgId, 404);

            $vals = $request->validated();
            $card = new \App\Modules\CreditCard\Domain\Entities\CreditCard(
                $existing->id(),
                $vals['name'],
                $orgId,
                $vals['bank_id'],
                null,
                (float) $vals['statement_amount'],
                isset($vals['limit']) ? (float) $vals['limit'] : null,
                $vals['closing_day'] ?? null,
                $vals['due_day'] ?? null,
                (bool) ($vals['is_active'] ?? false),
                $vals['color'] ?? null
            );

            $this->cardRepo->save($card);
            return redirect()->route('credit-cards.index')->with('success', 'Cartão atualizado.');
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->withInput()->with('error', 'Não foi possível atualizar o cartão.');
        }
    }

    public function destroy($id)
    {
        try {
            $orgId = Auth::user()->organization_id;
            $card = $this->cardRepo->findById($id);
            abort_unless($card && $card->organizationId() === $orgId, 404);
            $this->cardRepo->delete($card);
            return redirect()->route('credit-cards.index')->with('success', 'Cartão removido.');
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->with('error', 'Não foi possível remover o cartão.');
        }
    }
}
