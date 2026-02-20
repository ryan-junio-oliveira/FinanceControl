<?php

namespace App\Modules\Recipe\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Recipe\Application\UseCases\ListRecipes;
use App\Modules\Category\Infrastructure\Persistence\Eloquent\CategoryModel as Category;
use App\Modules\Recipe\Infrastructure\Persistence\Eloquent\RecipeModel as RecipeModel;
use App\Modules\Recipe\Presentation\Http\Requests\StoreRecipeRequest;
use App\Modules\Recipe\Presentation\Http\Requests\UpdateRecipeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class RecipeController extends Controller
{
    private ListRecipes $listRecipes;

    public function __construct(ListRecipes $listRecipes)
    {
        $this->listRecipes = $listRecipes;
    }

    public function index(Request $request)
    {
        try {
            $orgId = Auth::user()->organization_id;
            $q = $request->query('q');
            $perPage = (int) $request->query('per_page', 10);
            $perPage = in_array($perPage, [10,20,50,100]) ? $perPage : 10;

            $query = RecipeModel::where('organization_id', $orgId);
            if ($q) {
                $query->where('name', 'like', "%{$q}%");
            }

            $recipes = $query->orderByDesc('transaction_date')->paginate($perPage);
            return view('recipes.index', compact('recipes'));
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->with('error','Erro ao listar receitas.');
        }
    }

    public function create()
    {
        try {
            $orgId = Auth::user()->organization_id;
            $categories = Category::where('organization_id', $orgId)
                ->where('type', 'recipe')
                ->orderBy('name')
                ->get();

            return view('recipes.create', compact('categories'));
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->with('error','Erro ao abrir formulário de receita.');
        }
    }

    public function store(StoreRecipeRequest $request)
    {
        try {
            $orgId = Auth::user()->organization_id;
            $validated = $request->validated();
            $validated['organization_id'] = $orgId;
            // ensure fixed flag is boolean (defaults to false when not provided)
            $validated['fixed'] = $request->boolean('fixed');
            RecipeModel::create($validated);
            return redirect()->route('recipes.index')->with('success','Receita criada com sucesso!');
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->withInput()->with('error','Não foi possível criar receita.');
        }
    }

    public function show($id)
    {
        try {
            $orgId = Auth::user()->organization_id;
            $recipe = RecipeModel::where('organization_id', $orgId)->findOrFail($id);
            return view('recipes.show', compact('recipe'));
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->with('error','Erro ao exibir receita.');
        }
    }

    public function edit($id)
    {
        try {
            $orgId = Auth::user()->organization_id;
            $recipe = RecipeModel::where('organization_id', $orgId)->findOrFail($id);

            $categories = Category::where('organization_id', $orgId)
                ->where('type', 'recipe')
                ->orderBy('name')
                ->get();

            return view('recipes.edit', compact('recipe', 'categories'));
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->with('error','Erro ao carregar receita.');
        }
    }

    public function update(UpdateRecipeRequest $request, $id)
    {
        try {
            $orgId = Auth::user()->organization_id;
            $recipe = RecipeModel::where('organization_id', $orgId)->findOrFail($id);

            $data = $request->validated();
            // ensure fixed boolean is applied even if the field was omitted
            $data['fixed'] = $request->boolean('fixed');

            $recipe->update($data);
            return redirect()->route('recipes.index')->with('success','Receita atualizada com sucesso!');
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->withInput()->with('error','Não foi possível atualizar receita.');
        }
    }

    public function destroy($id)
    {
        try {
            $orgId = Auth::user()->organization_id;
            $recipe = RecipeModel::where('organization_id', $orgId)->findOrFail($id);
            $recipe->delete();
            return redirect()->route('recipes.index')->with('success','Receita removida com sucesso!');
        } catch (\Throwable $e) {
            Log::error($e);
            return redirect()->back()->with('error','Não foi possível remover receita.');
        }
    }
}
