<?php

declare(strict_types=1);

namespace App\Modules\Bank\Presentation\Http\Controllers;

use App\Contracts\UseCaseInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * Class BankController
 *
 * Thin HTTP layer. The controller is responsible only for
 * translating an HTTP request into a use‑case call and formatting
 * the response. All business logic lives in application/domain.
 */
final class BankController extends Controller
{
    private UseCaseInterface $listBanks;

    public function __construct(UseCaseInterface $listBanks)
    {
        $this->listBanks = $listBanks;
    }

    public function index(Request $request)
    {
        try {
            $orgId = Auth::id() ? Auth::user()->organization_id : null;

            $banks = $this->listBanks->execute($orgId);

            return view('banks.index', compact('banks'));
        } catch (\Throwable $e) {
            Log::error($e);

            return redirect()->back()->with('error', 'Erro ao listar bancos.');
        }
    }
}
