<?php

namespace App\Modules\Bank\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Bank\Application\UseCases\ListBanks;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BankController extends Controller
{
    private ListBanks $listBanks;

    public function __construct(ListBanks $listBanks)
    {
        $this->listBanks = $listBanks;
    }

    public function index()
    {
        try {
            $orgId = Auth::user()->organization_id;
            $banks = $this->listBanks->execute($orgId);
            return view('banks.index', compact('banks'));
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->with('error', 'Erro ao listar bancos.');
        }
    }
}
