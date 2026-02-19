<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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
        $categories = Category::where('organization_id', Auth::user()->organization_id)
            ->where('type', 'recipe')
            ->orderBy('name')
            ->get();

        return view('recipes.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $orgId = Auth::user()->organization_id;

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
            'fixed' => 'boolean',
            'category_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'id')->where(function ($query) use ($orgId) {
                    $query->where('organization_id', $orgId)->where('type', 'recipe');
                }),
            ],
        ]);

        $validated['organization_id'] = $orgId;
        Recipe::create($validated);
        return redirect()->route('recipes.index')->with('success', 'Receita criada com sucesso!');
    }

    public function edit(Recipe $recipe)
    {
        $categories = Category::where('organization_id', Auth::user()->organization_id)
            ->where('type', 'recipe')
            ->orderBy('name')
            ->get();

        return view('recipes.edit', compact('recipe', 'categories'));
    }

    public function update(Request $request, Recipe $recipe)
    {
        $orgId = Auth::user()->organization_id;

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
            'fixed' => 'boolean',
            'category_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'id')->where(function ($query) use ($orgId) {
                    $query->where('organization_id', $orgId)->where('type', 'recipe');
                }),
            ],
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
