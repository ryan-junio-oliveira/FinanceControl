<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrganizationController extends Controller
{
    public function edit()
    {
        $org = Auth::user()->organization;
        abort_unless($org, 404);

        $members = User::where('organization_id', $org->id)->orderBy('username')->get();

        return view('organization.edit', compact('org', 'members'));
    }

    public function update(Request $request)
    {
        $org = Auth::user()->organization;
        abort_unless($org, 404);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:organizations,name,' . $org->id,
        ]);

        $org->update($validated);

        return redirect()->route('organization.edit')->with('success', 'Organização atualizada.');
    }

    public function inviteMember(Request $request)
    {
        $org = Auth::user()->organization;
        abort_unless($org, 404);

        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
        ]);

        $password = Str::random(12);

        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => $password, // cast 'hashed' will hash it
            'organization_id' => $org->id,
        ]);

        // Note: no email sent by default (caller can manually inform the credential or implement mail later)
        return redirect()->route('organization.edit')->with('success', 'Membro convidado com sucesso.');
    }

    public function removeMember(User $user)
    {
        $org = Auth::user()->organization;
        abort_unless($org, 404);
        abort_unless($user->organization_id === $org->id, 404);
        abort_if($user->id === auth()->id(), 400, 'Não é possível remover o próprio usuário.');

        $user->organization_id = null;
        $user->save();

        return redirect()->route('organization.edit')->with('success', 'Membro removido.');
    }

    public function archive()
    {
        $org = Auth::user()->organization;
        abort_unless($org, 404);
        $org->archived_at = now();
        $org->save();

        return redirect()->route('organization.edit')->with('success', 'Organização arquivada. Será excluída automaticamente após 6 meses.');
    }

    public function unarchive()
    {
        $org = Auth::user()->organization;
        abort_unless($org, 404);
        $org->archived_at = null;
        $org->save();

        return redirect()->route('organization.edit')->with('success', 'Organização restaurada.');
    }

    public function destroy()
    {
        $org = Auth::user()->organization;
        abort_unless($org, 404);

        // permanent delete (cascades as defined in migrations)
        $org->delete();

        // detach current user to keep app consistent
        auth()->user()->organization_id = null;
        auth()->user()->save();

        return redirect('/')->with('success', 'Organização removida.');
    }
}
