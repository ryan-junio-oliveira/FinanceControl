<?php

namespace App\Modules\MonthlyFinancialControl\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\MonthlyFinancialControl\Application\UseCases\ListMonthlyFinancialControls;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MonthlyFinancialControlController extends Controller
{
    private ListMonthlyFinancialControls $listMfc;

    public function __construct(ListMonthlyFinancialControls $listMfc)
    {
        $this->listMfc = $listMfc;
    }

    public function index()
    {
        try {
            $orgId = Auth::user()->organization_id;
            $mfcs = $this->listMfc->execute($orgId);
            return view('monthly-controls.index', compact('mfcs'));
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->with('error', 'Erro ao listar controles mensais.');
        }
    }
}
