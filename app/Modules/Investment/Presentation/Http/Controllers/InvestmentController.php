<?php

namespace App\Modules\Investment\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Investment\Infrastructure\Persistence\Eloquent\InvestmentModel;
use App\Modules\Investment\Presentation\Http\Requests\StoreInvestmentRequest;
use App\Modules\Investment\Presentation\Http\Requests\UpdateInvestmentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class InvestmentController extends Controller
{
    public function index(Request $request)
    {
        try {
            $orgId = Auth::user()->organization_id;
            $q = $request->query('q');
            $perPage = (int) $request->query('per_page', 10);
            $perPage = in_array($perPage, [10,20,50,100]) ? $perPage : 10;

            $query = InvestmentModel::where('organization_id', $orgId);
            if ($q) {
                $query->where('name', 'like', "%{$q}%");
            }

            $investments = $query->orderByDesc('transaction_date')->paginate($perPage);
            return view('investments.index', compact('investments'));
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->with('error','Erro ao listar investimentos.');
        }
    }

    public function create()
    {
        try {
            return view('investments.create');
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->with('error','Erro ao abrir formulário de investimento.');
        }
    }

    public function store(StoreInvestmentRequest $request)
    {
        try {
            $orgId = Auth::user()->organization_id;
            $validated = $request->validated();
            $validated['organization_id'] = $orgId;
            InvestmentModel::create($validated);
            return redirect()->route('investments.index')->with('success','Investimento criado com sucesso!');
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->withInput()->with('error','Não foi possível criar investimento.');
        }
    }

    public function show($id)
    {
        try {
            $orgId = Auth::user()->organization_id;
            $investment = InvestmentModel::where('organization_id', $orgId)->findOrFail($id);
            return view('investments.show', compact('investment'));
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->with('error','Erro ao exibir investimento.');
        }
    }

    public function edit($id)
    {
        try {
            $orgId = Auth::user()->organization_id;
            $investment = InvestmentModel::where('organization_id', $orgId)->findOrFail($id);
            return view('investments.edit', compact('investment'));
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->with('error','Erro ao carregar investimento.');
        }
    }

    public function update(UpdateInvestmentRequest $request, $id)
    {
        try {
            $orgId = Auth::user()->organization_id;
            $investment = InvestmentModel::where('organization_id', $orgId)->findOrFail($id);
            $investment->update($request->validated());
            return redirect()->route('investments.index')->with('success','Investimento atualizado com sucesso!');
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->withInput()->with('error','Não foi possível atualizar investimento.');
        }
    }

    public function destroy($id)
    {
        try {
            $orgId = Auth::user()->organization_id;
            $investment = InvestmentModel::where('organization_id', $orgId)->findOrFail($id);
            $investment->delete();
            return redirect()->route('investments.index')->with('success','Investimento removido com sucesso!');
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->with('error','Não foi possível remover investimento.');
        }
    }
}
