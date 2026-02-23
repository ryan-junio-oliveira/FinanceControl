<?php

namespace App\Modules\Admin\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Modules\Admin\Application\Contracts\ListBanksInterface;
use App\Modules\Admin\Application\Contracts\ManageBankInterface;
use App\Modules\Admin\Domain\Contracts\BankRepositoryInterface;

class BankController extends Controller
{
    private ListBanksInterface $listUseCase;
    private ManageBankInterface $manageUseCase;
    private BankRepositoryInterface $bankRepo;

    public function __construct(ListBanksInterface $listUseCase, ManageBankInterface $manageUseCase, BankRepositoryInterface $bankRepo)
    {
        $this->listUseCase = $listUseCase;
        $this->manageUseCase = $manageUseCase;
        $this->bankRepo = $bankRepo;
    }

    public function index()
    {
        $banks = $this->listUseCase->execute();
        return view('admin.banks.index', compact('banks'));
    }

    public function create()
    {
        return view('admin.banks.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:banks,name',
        ]);

        try {
            $this->manageUseCase->create($data['name']);
            return redirect()->route('admin.banks.index')->with('success', 'Banco criado com sucesso.');
        } catch (\Throwable $e) {
            Log::error($e);
            return back()->withInput()->with('error', 'Não foi possível criar banco.');
        }
    }

    public function edit(int $id)
    {
        try {
            $bank = $this->bankRepo->findById($id);
            if (! $bank) {
                throw new \Exception('not found');
            }
            return view('admin.banks.edit', compact('bank'));
        } catch (\Throwable $e) {
            Log::error($e);
            return back()->with('error', 'Banco não encontrado.');
        }
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'name' => "required|string|max:255|unique:banks,name,{$id}",
        ]);

        try {
            $this->manageUseCase->update($id, $data['name']);
            return redirect()->route('admin.banks.index')->with('success', 'Banco atualizado.');
        } catch (\Throwable $e) {
            Log::error($e);
            return back()->withInput()->with('error', 'Não foi possível atualizar banco.');
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->manageUseCase->delete($id);
            return redirect()->route('admin.banks.index')->with('success', 'Banco removido.');
        } catch (\Throwable $e) {
            Log::error($e);
            return back()->with('error', 'Não foi possível remover banco.');
        }
    }
}
