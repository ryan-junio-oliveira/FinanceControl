<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::where('organization_id', Auth::user()->organization_id)
            ->orderByDesc('transaction_date')
            ->paginate(10);
        return view('recipes.index', compact('recipes'));
    }

    public function create()
    {
        return view('recipes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
            'received' => 'boolean',
        ]);
        $validated['organization_id'] = Auth::user()->organization_id;
        Recipe::create($validated);
        return redirect()->route('recipes.index')->with('success', 'Receita criada com sucesso!');
    }

    public function edit(Recipe $recipe)
    {
        return view('recipes.edit', compact('recipe'));
    }

    public function update(Request $request, Recipe $recipe)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
            'received' => 'boolean',
        ]);
        $recipe->update($validated);
        return redirect()->route('recipes.index')->with('success', 'Receita atualizada com sucesso!');
    }

    public function destroy(Recipe $recipe)
    {
        $recipe->delete();
        return redirect()->route('recipes.index')->with('success', 'Receita removida com sucesso!');
    }
}
