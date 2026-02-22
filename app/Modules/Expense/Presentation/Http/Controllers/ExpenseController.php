<?php

namespace App\Modules\Expense\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Expense\Application\UseCases\ListExpenses;
use App\Modules\Category\Infrastructure\Persistence\Eloquent\CategoryModel as Category;
use App\Modules\CreditCard\Infrastructure\Persistence\Eloquent\CreditCardModel as CreditCard;
use App\Modules\Expense\Infrastructure\Persistence\Eloquent\ExpenseModel;
use App\Modules\Expense\Presentation\Http\Requests\StoreExpenseRequest;
use App\Modules\Expense\Presentation\Http\Requests\UpdateExpenseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ExpenseController extends Controller
{
    private ListExpenses $listExpenses;

    public function __construct(ListExpenses $listExpenses)
    {
        $this->listExpenses = $listExpenses;
    }

    public function index(Request $request)
    {
        try {
            $orgId = Auth::user()->organization_id;
            $q = $request->query('q');
            $perPage = (int) $request->query('per_page', 10);
            $perPage = in_array($perPage, [10,20,50,100]) ? $perPage : 10;

            $query = ExpenseModel::where('organization_id', $orgId);
            if ($q) {
                $query->where('name', 'like', "%{$q}%");
            }

            $expenses = $query->orderByDesc('transaction_date')->paginate($perPage);
            return view('expenses.index', compact('expenses'));
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->with('error','Erro ao listar despesas.');
        }
    }

    public function create()
    {
        try {
            $orgId = Auth::user()->organization_id;

            $categories = Category::where('organization_id', $orgId)
                ->where('type', 'expense')
                ->where('name', '<>', 'Investimentos')
                ->orderBy('name')
                ->get();

            $creditCards = CreditCard::where('organization_id', $orgId)->orderBy('name')->get();

            return view('expenses.create', compact('categories', 'creditCards'));
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->with('error','Erro ao abrir formulário de despesa.');
        }
    }

    public function store(StoreExpenseRequest $request)
    {
        try {
            $orgId = Auth::user()->organization_id;
            $validated = $request->validated();
            $validated['organization_id'] = $orgId;
            ExpenseModel::create($validated);
            return redirect()->route('expenses.index')->with('success','Despesa criada com sucesso!');
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->withInput()->with('error','Não foi possível criar despesa.');
        }
    }

    public function show($id)
    {
        try {
            $orgId = Auth::user()->organization_id;
            $expense = ExpenseModel::where('organization_id', $orgId)->findOrFail($id);
            return view('expenses.show', compact('expense'));
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->with('error','Erro ao exibir despesa.');
        }
    }

    public function edit($id)
    {
        try {
            $orgId = Auth::user()->organization_id;
            $expense = ExpenseModel::where('organization_id', $orgId)->findOrFail($id);

            $categories = Category::where('organization_id', $orgId)
                ->where('type', 'expense')
                ->where('name', '<>', 'Investimentos')
                ->orderBy('name')
                ->get();

            $creditCards = CreditCard::where('organization_id', $orgId)->orderBy('name')->get();
            return view('expenses.edit', compact('expense', 'categories', 'creditCards'));
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->with('error','Erro ao carregar despesa.');
        }
    }

    public function update(UpdateExpenseRequest $request, $id)
    {
        try {
            $orgId = Auth::user()->organization_id;
            $expense = ExpenseModel::where('organization_id', $orgId)->findOrFail($id);
            $expense->update($request->validated());
            return redirect()->route('expenses.index')->with('success','Despesa atualizada com sucesso!');
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->withInput()->with('error','Não foi possível atualizar despesa.');
        }
    }

    public function destroy($id)
    {
        try {
            $orgId = Auth::user()->organization_id;
            $expense = ExpenseModel::where('organization_id', $orgId)->findOrFail($id);
            $expense->delete();
            return redirect()->route('expenses.index')->with('success','Despesa removida com sucesso!');
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->with('error','Não foi possível remover despesa.');
        }
    }
}
