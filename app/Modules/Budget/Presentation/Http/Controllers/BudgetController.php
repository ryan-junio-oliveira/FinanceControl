<?php

namespace App\Modules\Budget\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Budget\Application\UseCases\ListBudgets;
use App\Modules\Budget\Domain\Contracts\BudgetRepositoryInterface;
use App\Modules\Category\Domain\Contracts\CategoryRepositoryInterface;
use App\Modules\Budget\Presentation\Http\Requests\StoreBudgetRequest;
use App\Modules\Budget\Presentation\Http\Requests\UpdateBudgetRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BudgetController extends Controller
{
    private ListBudgets $listBudgets;
    private BudgetRepositoryInterface $budgetRepo;
    private CategoryRepositoryInterface $categoryRepo;

    public function __construct(
        ListBudgets $listBudgets,
        BudgetRepositoryInterface $budgetRepo,
        CategoryRepositoryInterface $categoryRepo
    ) {
        $this->listBudgets = $listBudgets;
        $this->budgetRepo = $budgetRepo;
        $this->categoryRepo = $categoryRepo;
    }

    public function index(Request $request)
    {
        try {
            $orgId = Auth::user()->organization_id;
            $budgets = collect($this->listBudgets->execute($orgId));
            return view('budgets.index', compact('budgets'));
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->with('error', 'Erro ao listar orçamentos.');
        }
    }

    public function create()
    {
        try {
            $orgId = Auth::user()->organization_id;
            $categories = $this->categoryRepo->listByOrganization($orgId);
            return view('budgets.create', compact('categories'));
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->with('error', 'Erro ao carregar formulário de orçamento.');
        }
    }

    public function store(StoreBudgetRequest $request)
    {
        try {
            $orgId = Auth::user()->organization_id;
            $validated = $request->validated();
            $validated['organization_id'] = $orgId;
            $validated['is_active'] = $validated['is_active'] ?? true;

            $start = new \DateTime($validated['start_date']);
            $end = new \DateTime($validated['end_date']);
            $entity = new \App\Modules\Budget\Domain\Entities\Budget(
                0,
                $validated['name'],
                (float) $validated['amount'],
                $start,
                $end,
                $validated['category_id'] ?? null,
                (bool) $validated['is_active'],
                $orgId
            );
            $this->budgetRepo->save($entity);

            return redirect()->route('budgets.index')->with('success', 'Orçamento criado com sucesso.');
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->withInput()->with('error', 'Não foi possível criar o orçamento.');
        }
    }

    public function edit(int $id)
    {
        try {
            $orgId = Auth::user()->organization_id;
            $budget = $this->budgetRepo->findById($id);
            abort_unless($budget && $budget->organizationId() === $orgId, 404);

            $categories = $this->categoryRepo->listByOrganization($orgId);

            return view('budgets.edit', compact('budget', 'categories'));
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->with('error', 'Erro ao carregar formulário de edição.');
        }
    }

    public function update(UpdateBudgetRequest $request, int $id)
    {
        try {
            $orgId = Auth::user()->organization_id;
            $budget = $this->budgetRepo->findById($id);
            abort_unless($budget && $budget->organizationId() === $orgId, 404);

            $validated = $request->validated();
            $start = new \DateTime($validated['start_date']);
            $end = new \DateTime($validated['end_date']);

            $updated = new \App\Modules\Budget\Domain\Entities\Budget(
                $budget->id(),
                $validated['name'],
                (float) $validated['amount'],
                $start,
                $end,
                $validated['category_id'] ?? null,
                (bool) ($validated['is_active'] ?? $budget->isActive()),
                $orgId
            );
            $this->budgetRepo->save($updated);

            return redirect()->route('budgets.index')->with('success', 'Orçamento atualizado.');
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->withInput()->with('error', 'Não foi possível atualizar o orçamento.');
        }
    }

    public function show(int $id)
    {
        try {
            $orgId = Auth::user()->organization_id;
            $budget = $this->budgetRepo->findById($id);
            abort_unless($budget && $budget->organizationId() === $orgId, 404);

            // fetch expenses within period
            $query = \App\Modules\Expense\Infrastructure\Persistence\Eloquent\ExpenseModel::where('organization_id', $orgId)
                ->whereBetween('transaction_date', [
                    $budget->startDate()->format('Y-m-d'),
                    $budget->endDate()->format('Y-m-d'),
                ]);
            if ($budget->categoryId()) {
                $query->where('category_id', $budget->categoryId());
            }

            $expenses = $query->orderByDesc('transaction_date')->get();

            $spent = $this->budgetRepo->calculateSpent($budget);
            $progress = $budget->amount() ? min(100.0, round(($spent / $budget->amount()) * 100, 2)) : 0.0;

            return view('budgets.show', compact('budget', 'expenses', 'spent', 'progress'));
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->with('error', 'Erro ao carregar detalhes do orçamento.');
        }
    }

    public function destroy(int $id)
    {
        try {
            $orgId = Auth::user()->organization_id;
            $budget = $this->budgetRepo->findById($id);
            abort_unless($budget && $budget->organizationId() === $orgId, 404);
            $this->budgetRepo->delete($budget);
            return redirect()->route('budgets.index')->with('success', 'Orçamento removido.');
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->with('error', 'Não foi possível remover o orçamento.');
        }
    }
}
