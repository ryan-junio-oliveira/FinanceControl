<?php

namespace App\Modules\Organization\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Organization\Application\UseCases\ListOrganizations;
use App\Modules\Organization\Presentation\Http\Requests\UpdateOrganizationRequest;
use App\Modules\Organization\Presentation\Http\Requests\InviteOrganizationRequest;
use App\Services\OrganizationInviteService;
use App\Models\User;
use App\Modules\Organization\Infrastructure\Persistence\Eloquent\OrganizationModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class OrganizationController extends Controller
{
    private ListOrganizations $listOrganizations;

    public function __construct(ListOrganizations $listOrganizations)
    {
        $this->listOrganizations = $listOrganizations;
    }

    public function index()
    {
        $orgs = $this->listOrganizations->execute();
        return view('organizations.index', compact('orgs'));
    }

    public function edit()
    {
        try {
            $org = OrganizationModel::findOrFail(Auth::user()->organization_id);
            return view('organization.edit', compact('org'));
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->with('error', 'Erro ao carregar organização.');
        }
    }

    public function update(UpdateOrganizationRequest $request)
    {
        try {
            $org = OrganizationModel::findOrFail(Auth::user()->organization_id);
            $org->name = $request->name;
            $org->save();
            return redirect()->route('organization.edit')->with('success', 'Organização atualizada.');
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->withInput()->with('error', 'Não foi possível atualizar a organização.');
        }
    }

    public function inviteMember(InviteOrganizationRequest $request)
    {
        try {
            $orgId = Auth::user()->organization_id;
            $service = new OrganizationInviteService();
            $service->invite($request->username, $request->email, $orgId);
            return redirect()->route('organization.edit')->with('success', 'Usuário convidado.');
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->withInput()->with('error', 'Não foi possível convidar usuário.');
        }
    }

    public function removeMember(User $user)
    {
        try {
            // only allow removal of users in same org
            if ($user->organization_id === Auth::user()->organization_id) {
                $user->organization_id = null;
                $user->save();
            }
            return redirect()->route('organization.edit')->with('success', 'Membro removido.');
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->with('error', 'Não foi possível remover o membro.');
        }
    }

    public function archive()
    {
        try {
            $org = OrganizationModel::findOrFail(Auth::user()->organization_id);
            $org->archived_at = Carbon::now();
            $org->save();
            return redirect()->route('organization.edit')->with('success', 'Organização arquivada.');
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->with('error', 'Não foi possível arquivar.');
        }
    }

    public function unarchive()
    {
        try {
            $org = OrganizationModel::findOrFail(Auth::user()->organization_id);
            $org->archived_at = null;
            $org->save();
            return redirect()->route('organization.edit')->with('success', 'Organização desarquivada.');
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->with('error', 'Não foi possível desarquivar.');
        }
    }

    public function destroy()
    {
        try {
            $org = OrganizationModel::findOrFail(Auth::user()->organization_id);
            $org->delete();
            return redirect()->route('dashboard')->with('success', 'Organização excluída.');
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->with('error', 'Não foi possível excluir organização.');
        }
    }
}
